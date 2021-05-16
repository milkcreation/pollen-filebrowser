<?php

declare(strict_types=1);

namespace Pollen\Filebrowser;

use Pollen\Filebrowser\Controller\SpritesController;
use Pollen\Filebrowser\Exception\FilebrowserNotFound;
use Pollen\Filebrowser\Exception\FilebrowserRouteNotFound;
use Pollen\Filebrowser\Exception\FilebrowserUnresolvable;
use Pollen\Filesystem\FilesystemInterface;
use Pollen\Routing\RouteInterface;
use Pollen\Support\Concerns\BootableTrait;
use Pollen\Support\Concerns\ConfigBagAwareTrait;
use Pollen\Support\Concerns\ResourcesAwareTrait;
use Pollen\Support\Exception\ManagerRuntimeException;
use Pollen\Support\Proxy\ContainerProxy;
use Pollen\Support\Proxy\RouterProxy;
use Pollen\Support\Proxy\StorageProxy;
use Psr\Container\ContainerInterface as Container;
use Throwable;

class FilebrowserManager implements FilebrowserManagerInterface
{
    use BootableTrait;
    use ConfigBagAwareTrait;
    use ContainerProxy;
    use ResourcesAwareTrait;
    use RouterProxy;
    use StorageProxy;

    /**
     * Instance principale.
     * @var static|null
     */
    private static $instance;

    /**
     * Liste des définitions de navigateurs de fichiers.
     * @var string[]|array[]|FileBrowserInterface[][]|array
     */
    protected $browserDefs = [];

    /**
     * Liste des navigateurs de fichiers déclarés.
     * @var FileBrowserInterface[][]|array
     */
    protected $browsers = [];

    /**
     * @var RouteInterface[]
     */
    protected $routes = [];

    /**
     * @param array $config
     * @param Container|null $container
     *
     * @return void
     */
    public function __construct(array $config = [], ?Container $container = null)
    {
        $this->setConfig($config);

        if ($container !== null) {
            $this->setContainer($container);
        }

        if (!self::$instance instanceof static) {
            self::$instance = $this;
        } else {
            return;
        }

        $this->boot();
    }

    /**
     * Récupération de l'instance principale.
     *
     * @return static
     */
    public static function getInstance(): FilebrowserManagerInterface
    {
        if (self::$instance instanceof self) {
            return self::$instance;
        }
        throw new ManagerRuntimeException(sprintf('Unavailable [%s] instance', __CLASS__));
    }

    /**
     * @inheritDoc
     */
    public function boot(): void
    {
        if (!$this->isBooted()) {
            $this->setResourcesBaseDir(dirname(__DIR__) . '/resources');

            $this->routes['sprites'] = $this->router()->get(
                'api/'. md5(__CLASS__). '/sprites/{sprite}', SpritesController::class
            );

            $this->setBooted();
        }
    }

    /**
     * @inheritDoc
     */
    public function addBrowser(string $name, FilebrowserInterface $filebrowser): FilebrowserInterface
    {
        return $this->browserDefs['name'] = $filebrowser;
    }

    /**
     * @inheritDoc
     */
    public function get(string $name): FilebrowserInterface
    {
        try {
            return $this->resolveBrowser($name);
        } catch (Throwable $e) {
            throw new FilebrowserNotFound($name, '', 0, $e);
        }
    }

    /**
     * @inheritDoc
     */
    public function getRoute(string $endpoint): RouteInterface
    {
        if (isset($this->routes[$endpoint])) {
            return $this->routes[$endpoint];
        }
        throw new FilebrowserRouteNotFound($endpoint);
    }

    /**
     * @inheritDoc
     */
    public function getRouteUrl(string $endpoint, array $args = [], bool $isAbsolute = false): string
    {
        return $this->router()->getRouteUrl($this->getRoute($endpoint), $args, $isAbsolute);
    }

    /**
     * @inheritDoc
     */
    public function registerBrowser(string $name, $filebrowserDef): FilebrowserManagerInterface
    {
        $this->browserDefs[$name] = $filebrowserDef;

        return $this;
    }

    /**
     * Résolution d'un navigateur de fichier défini.
     *
     * @param string $name
     *
     * @return FilebrowserInterface
     */
    protected function resolveBrowser(string $name): FilebrowserInterface
    {
        if (isset($this->browsers[$name])) {
            return $this->browsers[$name];
        }

        if (!$def = $this->browserDefs[$name] ?? null) {
            throw new FilebrowserUnresolvable(
                sprintf(
                    'Could not resolve Filebrowser [%s]. Filebrowser definition unavailable',
                    $name
                )
            );
        }

        if ($def instanceof FilebrowserInterface) {
            $filebrowser = $def;
        } elseif (is_string($def)) {
            try {
                $filesystem = $this->storage()->createLocalFilesystem($def);
                $filebrowser = new Filebrowser($filesystem);
            } catch(Throwable $e) {
                throw new FilebrowserUnresolvable(
                    sprintf(
                        'Could not resolve Filebrowser [%s]. Local path [%s] could be unavailable',
                        $name,
                        $def
                    )
                );
            }
        } elseif (is_array($def)) {
            if (!$filesystem = $def['filesystem'] ?? null) {
                throw new FilebrowserUnresolvable(
                    sprintf(
                        'Could not resolve Filebrowser [%s]. A "filesystem" attributes is required.',
                        $name,
                    )
                );
            }

            unset($def['filesystem']);

            if ($filesystem instanceof FilesystemInterface) {
                $filebrowser = new Filebrowser($filesystem, $def);
            } elseif (is_string($filesystem)) {
                try {
                    $filesystem = $this->storage()->createLocalFilesystem($filesystem);
                    $filebrowser = new Filebrowser($filesystem, $def);
                } catch(Throwable $e) {
                    throw new FilebrowserUnresolvable(
                        sprintf(
                            'Could not resolve Filebrowser [%s]. Local path [%s] could be unavailable',
                            $name,
                            $filesystem
                        )
                    );
                }
            } else {
                throw new FilebrowserUnresolvable(
                    sprintf(
                        'Could not resolve Filebrowser [%s]. The "filesystem" attributes must be a' .
                        'FilesystemInterface instance or a the string path of local files',
                        $name
                    )
                );
            }
        } else {
            throw new FilebrowserUnresolvable(
                sprintf(
                    'Could not resolve Filebrowser [%s]. ' .
                    'Filebrowser definition must an FilebrowserInterface instance or an array of attributes or ' .
                    ' a the string path of local files',
                    $name
                )
            );
        }

        return $filebrowser->setName($name)->setManager($this);
    }
}