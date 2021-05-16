<?php

declare(strict_types=1);

namespace Pollen\Filebrowser;

use Pollen\Filebrowser\Exception\FilebrowserInvalidFactory;
use Pollen\Filebrowser\Exception\FilebrowserUnresolvableFactory;
use Pollen\Filebrowser\Factory\Breadcrumb;
use Pollen\Filebrowser\Factory\Controller;
use Pollen\Filebrowser\Factory\FactoryInterface;
use Pollen\Filebrowser\Factory\FileCollector;
use Pollen\Filebrowser\Factory\FileCollectorInterface;
use Pollen\Filebrowser\Factory\FileInfoInterface;
use Pollen\Filebrowser\Factory\IconCollection;
use Pollen\Filesystem\FilesystemInterface;
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
    protected $currentPath = 'test1';

    /**
     * @var string
     */
    protected $viewEngine;

    /**
     * @var Factory\Breadcrumb
     */
    public $breadcrumb;

    /**
     * @var Factory\Controller
     */
    public $controller;

    /**
     * @var Factory\FileCollector
     */
    public $files;

    /**
     * @var Factory\IconCollection
     */
    public $icons;

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
            $this->breadcrumb = $this->resolveFactory(Breadcrumb::class);
            $this->controller = $this->resolveFactory(Controller::class);
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
            'attrs' => [
                'class' => 'Filebrowser',
            ],
        ];
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
    public function getCurrentFiles(): FileCollectorInterface
    {
        return $this->files->fetch($this->getCurrentPath());
    }

    /**
     * @inheritDoc
     */
    public function getCurrentPath(): string
    {
        return $this->currentPath;
    }

    /**
     * @inheritDoc
     */
    public function getFileIcon(FileInfoInterface $file): string
    {
        return $this->icons->fileRender($file);
    }

    /**
     * @inheritDoc
     */
    public function getIcon(string $name): string
    {
        return $this->icons->render($name);
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
    public function getName(): string
    {
        return $this->name;
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
     * @inheritDoc
     */
    public function render(): string
    {
        $this->breadcrumb->fetch($this->getCurrentPath());
        $breadcrumb = $this->breadcrumb;
        $files = $this->getCurrentFiles();

        $this->params([
            'breadcrumb' => $breadcrumb,
            'files' => $files,
        ]);

        return $this->view('index', $this->params()->all());
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

    /**
     * @inheritDoc
     */
    public function setCurrentPath(string $path): FilebrowserInterface
    {
        $this->currentPath = $path;

        return $this;
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
        return $this->getViewEngine()->render($name, $datas);
    }
}