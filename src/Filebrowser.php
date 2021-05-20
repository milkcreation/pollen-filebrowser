<?php

declare(strict_types=1);

namespace Pollen\Filebrowser;

use Exception;
use Pollen\Filebrowser\Exception\FilebrowserActionInvalidArgument;
use Pollen\Filebrowser\Exception\FilebrowserActionNotFound;
use Pollen\Filebrowser\Exception\FilebrowserInvalidFactory;
use Pollen\Filebrowser\Exception\FilebrowserUnresolvableFactory;
use Pollen\Filebrowser\Factory\Actions;
use Pollen\Filebrowser\Factory\ActionsInterface;
use Pollen\Filebrowser\Factory\Breadcrumb;
use Pollen\Filebrowser\Factory\BreadcrumbInterface;
use Pollen\Filebrowser\Factory\FactoryInterface;
use Pollen\Filebrowser\Factory\FileCollector;
use Pollen\Filebrowser\Factory\FileCollectorInterface;
use Pollen\Filebrowser\Factory\FileInfoInterface;
use Pollen\Filebrowser\Factory\IconCollection;
use Pollen\Filebrowser\Factory\IconCollectionInterface;
use Pollen\Filebrowser\Factory\PathInfo;
use Pollen\Filebrowser\Factory\PathInfoInterface;
use Pollen\Filebrowser\Factory\SelectInfo;
use Pollen\Filebrowser\Factory\SelectInfoInterface;
use Pollen\Filesystem\FilesystemInterface;
use Pollen\Http\RequestInterface;
use Pollen\Support\Concerns\BuildableTrait;
use Pollen\Support\Concerns\ParamsBagAwareTrait;
use Pollen\View\ViewEngine;
use Pollen\View\ViewEngineInterface;

class Filebrowser implements FilebrowserInterface
{
    use BuildableTrait;
    use ParamsBagAwareTrait;

    /**
     * Instance du gestionnaire de fichier associé.
     * @var FilesystemInterface
     */
    protected $filesystem;

    /**
     * Instance du gestionnaires de navigateur de fichier.
     * @var FilebrowserManagerInterface
     */
    protected $manager;

    /**
     * Nom de qualification du navigateur de fichier.
     * @var string
     */
    protected $name = '';

    /**
     * Chemin relatif vers la ressource courante (dossier ou fichier)
     * @var string
     */
    protected $path = '/';

    /**
     * Chemin relatif vers la ressource sélectionnée (dossier ou fichier)
     * @var string|null
     */
    protected $selected;

    /**
     * @var string
     */
    protected $viewEngine;

    /**
     * @var ActionsInterface
     */
    public $actions;

    /**
     * @var BreadcrumbInterface
     */
    public $breadcrumb;

    /**
     * @var FileCollectorInterface
     */
    public $files;

    /**
     * @var IconCollectionInterface
     */
    public $icons;

    /**
     * @var PathInfoInterface
     */
    public $pathinfo;

    /**
     * @var SelectInfoInterface|null|false
     */
    public $selectinfo;

    /**
     * @param FilesystemInterface $filesystem
     * @param array $params
     */
    public function __construct(FilesystemInterface $filesystem, array $params = [])
    {
        $this->filesystem = $filesystem;
        $this->setParams($params);

        $this->build();
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return $this->render();
    }

    /**
     * @inheritDoc
     */
    public function build(): void
    {
        if (!$this->isBuilt()) {
            $this->actions = $this->resolveFactory(Actions::class);
            $this->breadcrumb = $this->resolveFactory(Breadcrumb::class);
            $this->files = $this->resolveFactory(FileCollector::class);
            $this->icons = $this->resolveFactory(IconCollection::class);

            $this->setBuilt();
        }
    }

    /**
     * @inheritDoc
     */
    public function defaultParams(): array
    {
        return [
            'attrs'   => [
                'class' => 'Filebrowser',
            ],
            'observe' => true,
        ];
    }

    /**
     * @inheritDoc
     */
    public function doAction(string $actionName, RequestInterface $request)
    {
        if (!method_exists($this->actions, $actionName)) {
            throw new FilebrowserActionNotFound($actionName);
        }

        try {
            $args = $this->actions->parseRequestArgs($actionName, $request);
        } catch (Exception $e) {
            throw new FilebrowserActionInvalidArgument($actionName, $e->getMessage(), 0, $e);
        }

        return $this->actions->$actionName(...$args);
    }

    /**
     * @inheritDoc
     */
    public function filesystem(): FilesystemInterface
    {
        return $this->filesystem;
    }

    /**
     * @inheritDoc
     */
    public function getActionUrl(?string $action = null, array $args = []): string
    {
        $args = array_merge(
            $args,
            [
                'name' => $this->getName(),
            ]
        );

        if ($action !== null) {
            $args['action'] = $action;
        }

        return $this->manager()->getRouteUrl('filebrowser-action', $args);
    }

    /**
     * @inheritDoc
     */
    public function getFileIcon(FileInfoInterface $file, array $attrs = [], ?string $placeholder = 'file'): string
    {
        return $this->icons->fileRender($file, $attrs, $placeholder);
    }

    /**
     * @inheritDoc
     */
    public function getIcon(string $name, array $attrs = [], ?string $placeholder = '_default'): string
    {
        return $this->icons->render($name, $attrs, $placeholder);
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @inheritDoc
     */
    public function getPathInfo(): PathInfoInterface
    {
        if ($this->pathinfo === null) {
            $this->pathinfo = new PathInfo($this->getPath(), $this);
        }
        return $this->pathinfo;
    }

    /**
     * @inheritDoc
     */
    public function getSelected(): ?string
    {
        return $this->selected;
    }

    /**
     * @inheritDoc
     */
    public function getSelectedInfo(): ?SelectInfoInterface
    {
        if ($this->selectinfo === null) {
            $this->selectinfo = $this->getSelected() ? new SelectInfo($this->getSelected(), $this) : false;
        }
        return $this->selectinfo ?: null;
    }

    /**
     * @inheritDoc
     */
    public function manager(): FilebrowserManagerInterface
    {
        if ($this->manager === null) {
            $this->manager = FilebrowserManager::getInstance();
        }
        return $this->manager;
    }

    /**
     * @inheritDoc
     */
    public function render(): string
    {
        $this->renderParse();

        if ($this->params('observe', true)) {
            $this->params(['attrs.data-observe' => 'filebrowser']);
        }

        $this->params(
            [
                'attrs.data-options' => [
                    'endpoint' => $this->getActionUrl(),
                ],
            ]
        );

        return $this->view('index');
    }

    /**
     * @inheritDoc
     */
    public function renderParse(): void
    {
        $this->breadcrumb->fetch($this->getPathInfo()->path());
        $this->files->fetch($this->getPathInfo()->path());

        $this->params(
            [
                'pathinfo'   => $this->getPathInfo(),
                'selectinfo' => $this->getSelectedInfo(),
                'breadcrumb' => $this->breadcrumb,
                'files'      => $this->files,
            ]
        );
    }

    /**
     * Définition du gestionnaire de navigateurs de fichiers
     *
     * @param FilebrowserManagerInterface $manager
     *
     * @return static
     */
    public function setManager(FilebrowserManagerInterface $manager): FilebrowserInterface
    {
        $this->manager = $manager;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setName(string $name): FilebrowserInterface
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setPath(string $path): FilebrowserInterface
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setSelected(?string $path = null): FilebrowserInterface
    {
        $this->selected = $path;
        $this->selectinfo = null;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setViewEngine(ViewEngineInterface $viewEngine): FilebrowserInterface
    {
        $this->viewEngine = $viewEngine;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function view(string $name, array $datas = []): string
    {
        return $this->getViewEngine()->render($name, array_merge($this->params()->all(), $datas));
    }

    /**
     * Moteur d'affichage des gabarits d'affichage.
     *
     * @return ViewEngineInterface
     */
    protected function getViewEngine(): ViewEngineInterface
    {
        if ($this->viewEngine === null) {
            $this->viewEngine = (new ViewEngine())
                ->setDirectory($this->manager()->resources('/views'))
                ->setLoader(FilebrowserViewLoader::class)
                ->setDelegate($this)
                ->setDelegateMixin('getIcon');
        }
        return $this->viewEngine;
    }

    /**
     * @param string $classname
     * @param mixed ...$args
     *
     *
     * @return FactoryInterface
     */
    protected function resolveFactory(string $classname, ...$args): FactoryInterface
    {
        if (class_exists($classname)) {
            $factory = new $classname(...$args);
            if (!$factory instanceof FactoryInterface) {
                throw new FilebrowserInvalidFactory(
                    sprintf(
                        'Filebrowser Factory class [%s] must be an instance of %s',
                        $classname,
                        FactoryInterface::class
                    )
                );
            }
            $factory->setFilebrowser($this);

            return $factory;
        }

        throw new FilebrowserUnresolvableFactory(
            sprintf(
                'Filebrowser Factory class [%s] unavailable',
                $classname,
            )
        );
    }
}