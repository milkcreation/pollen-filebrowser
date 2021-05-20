<?php

declare(strict_types=1);

namespace Pollen\Filebrowser\Factory;

use League\Flysystem\FilesystemException;
use Pollen\Http\RequestInterface;
use Pollen\Http\BinaryFileResponse;
use Pollen\Filebrowser\Exception\FilebrowserActionNotice;
use Pollen\Http\BinaryFileResponseInterface;
use Pollen\Support\Proxy\PartialProxy;
use Pollen\Support\Proxy\ValidatorProxy;
use Pollen\Support\Filesystem as fs;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Throwable;

class Actions implements ActionsInterface
{
    use FilebrowserAwareTrait;
    use PartialProxy;
    use ValidatorProxy;

    /**
     * @inheritDoc
     */
    public function browse(string $path): array
    {
        $fb = $this->filebrowser()->setPath($path)->setSelected();
        $fb->renderParse();

        return [
            'viewBreadcrumb'    => $fb->view('breadcrumb'),
            'viewFileCards'     => $fb->view('file-cards'),
            'sidebarSelectinfo' => $fb->view('selected-info'),
            'sidebarRename'     => $fb->view('selected-rename'),
            'sidebarDelete'     => $fb->view('selected-delete'),
            'sidebarPathinfo'   => $fb->view('path-info'),
            'sidebarCreate'     => $fb->view('path-create'),
            'sidebarUpload'     => $fb->view('path-upload'),
        ];
    }

    /**
     * @inheritDoc
     */
    public function createDir(string $path, string $name): array
    {
        $fb = $this->filebrowser()->setPath($path);
        $pathinfo = $fb->getPathInfo();

        if (!$this->validator('notEmpty')->validate($name)) {
            throw new FilebrowserActionNotice('warning', 'Le nom du dossier ne peut être vide.');
        }

        $path = fs::normalizePath($pathinfo->dirname() . "/$name");

        try {
            $fb->filesystem()->read($path);

            throw new FilebrowserActionNotice(
                'warning', 'Un dossier portant ce nom autre existe déjà dans le répertoire courant.', 'createDir'
            );
        } catch (FilesystemException $e) {
            unset($e);
        }

        try {
            $fb->filesystem()->createDirectory($path);
            $fb->setSelected($path);
            $fb->renderParse();

            return [
                'viewBreadcrumb'    => $fb->view('breadcrumb'),
                'viewFileCards'     => $fb->view('file-cards'),
                'sidebarSelectinfo' => $fb->view('selected-info'),
                'sidebarRename'     => $fb->view('selected-rename'),
                'sidebarDelete'     => $fb->view('selected-delete'),
            ];
        } catch (FilesystemException $e) {
            throw new FilebrowserActionNotice(
                'warning', 'ERREUR SYSTÈME: Impossible de créer le dossier.', 'createDir'
            );
        }
    }

    /**
     * @inheritDoc
     */
    public function delete(string $path): array
    {
        $fb = $this->filebrowser();
        $fb->setSelected($path);

        if (!$selectinfo = $fb->getSelectedInfo()) {
            throw new FilebrowserActionNotice(
                'warning', 'Impossible de retrouver la ressource à supprimer.', 'delete'
            );
        }

        $dirname = $selectinfo->getDirname();

        if ($selectinfo->isDir()) {
            try {
                $fb->filesystem()->deleteDirectory($path);
            } catch (FilesystemException $e) {
                throw new FilebrowserActionNotice(
                    'error', 'ERREUR SYSTÈME: Impossible de supprimer la répertoire.', 'delete', 0, $e
                );
            }
        } elseif ($selectinfo->isFile()) {
            try {
                $fb->filesystem()->delete($path);
            } catch (FilesystemException $e) {
                throw new FilebrowserActionNotice(
                    'error', 'ERREUR SYSTÈME: Impossible de supprimer le fichier.', 'delete', 0, $e
                );
            }
        } else {
            throw new FilebrowserActionNotice(
                'error', 'ERREUR SYSTÈME: Impossible de determiner le type de ressource.', 'delete'
            );
        }

        $fb->setPath($dirname)->setSelected();
        $fb->renderParse();

        return [
            'viewBreadcrumb'    => $fb->view('breadcrumb'),
            'viewFileCards'     => $fb->view('file-cards'),
            'sidebarSelectinfo' => $fb->view('selected-info'),
            'sidebarRename'     => $fb->view('selected-rename'),
            'sidebarDelete'     => $fb->view('selected-delete'),
        ];
    }

    /**
     * @inheritDoc
     */
    public function downloadFile(string $path): BinaryFileResponseInterface
    {
        try {
            $file = $this->filebrowser()->filesystem()->getAbsolutePath($path);

            $response = new BinaryFileResponse($file);

            $filename = $response->getFile()->getFilename();
            $response->headers->set('Content-Type', $response->getFile()->getMimeType());
            $response->setContentDisposition('attachment', $filename);

            return $response;
        } catch (Throwable $e) {
            throw new FilebrowserActionNotice(
                'error', 'ERREUR SYSTÈME: Impossible de télécharger le fichier.', 'downloadFile', 0, $e
            );
        }
    }

    /**
     * @inheritDoc
     */
    public function parseRequestArgs(string $action, RequestInterface $request): array
    {
        switch ($action) {
            default:
                return [];
            case 'browse':
            case 'select':
            case 'createDir':
            case 'delete':
            case 'rename':
                return array_values($request->input('args', []));
            case 'downloadFile':
                $path = $request->input('path', '');

                return [$path];
            case 'uploadFile' :
                $path = $request->input('path', '');
                foreach ($request->files as $fileUpload) {
                    $file = $fileUpload;
                    break;
                }
                $fullPath = $request->input('fullPath');

                return [$path, $file, $fullPath];
        }
    }

    /**
     * @inheritDoc
     */
    public function uploadFile(string $path, UploadedFile $file, ?string $fullPath = null): array
    {
        $fb = $this->filebrowser();

        if ($fullPath !== null) {
            $newPath = dirname($fullPath);
            $newPath = fs::normalizePath("$path/$newPath");

            try {
                $fb->filesystem()->createDirectory($newPath);

                $destPath = "$newPath/" . $file->getClientOriginalName();
            } catch (FilesystemException $e) {
                throw new FilebrowserActionNotice(
                    'error',
                    'ERREUR SYSTÈME: Impossible de créer le répertoire d\'import du fichier.',
                    'uploadFile',
                    0,
                    $e
                );
            }
        } else {
            $destPath = "$path/" . $file->getClientOriginalName();
        }

        try {
            $fb->filesystem()->read($destPath);

            throw new FilebrowserActionNotice(
                'warning',
                sprintf(
                    'Il existe déjà un autre fichier avec le nom [%s] dans le répertoire [%s].',
                    basename($destPath),
                    dirname($destPath)
                ),
                'uploadFile'
            );
        } catch (FilesystemException $e) {
            unset($e);
        }

        try {
            $fb->filesystem()->write($destPath, $file->getContent());
        } catch (FilesystemException $e) {
            throw new FilebrowserActionNotice(
                'error', 'ERREUR SYSTÈME: Impossible d\'importer le fichier.', 'uploadFile', 0, $e
            );
        }

        return [
            'success' => true,
            'datas'   => $fullPath,
        ];
    }

    /**
     * @inheritDoc
     */
    public function rename(string $path, string $name): array
    {
        $fb = $this->filebrowser();
        $fb->setSelected($path);

        if (!$selectinfo = $fb->getSelectedInfo()) {
            throw new FilebrowserActionNotice(
                'warning', 'Impossible de retrouver la ressource à renommer.', 'rename'
            );
        }

        if (!$this->validator('notEmpty')->validate($name)) {
            throw new FilebrowserActionNotice(
                'warning', 'Le nom ne peut être vide.', 'rename'
            );
        }

        /*$newpath .= ($file->isFile() && (request()->input('keep') === 'on') && $file->getExtension())
            ? '.' . $file->getExtension()
            : ''; */

        $newPath = fs::normalizePath($selectinfo->getDirname() . "/$name");

        try {
            $fb->filesystem()->read($newPath);

            throw new FilebrowserActionNotice(
                'warning', 'Une autre ressource porte déjà ce nom.', 'rename'
            );
        } catch (FilesystemException $e) {
            unset($e);
        }

        try {
            $fb->filesystem()->move($path, $newPath);

            $fb->setPath($selectinfo->getDirname())->setSelected($newPath);
            $fb->renderParse();

            return [
                'viewBreadcrumb'    => $fb->view('breadcrumb'),
                'viewFileCards'     => $fb->view('file-cards'),
                'sidebarSelectinfo' => $fb->view('selected-info'),
                'sidebarRename'     => $fb->view('selected-rename'),
                'sidebarDelete'     => $fb->view('selected-delete'),
            ];
        } catch (FilesystemException $e) {
            throw new FilebrowserActionNotice(
                'error', 'ERREUR SYSTÈME: Impossible de modifier le nom de la ressource.', 'rename', 0, $e
            );
        }
    }

    /**
     * @inheritDoc
     */
    public function select(string $path = ''): array
    {
        $fb = $this->filebrowser()->setPath($path)->setSelected($path);
        $fb->renderParse();

        return [
            'sidebarSelectinfo' => $fb->view('selected-info'),
            'sidebarRename'     => $fb->view('selected-rename'),
            'sidebarDelete'     => $fb->view('selected-delete'),
        ];
    }
}
