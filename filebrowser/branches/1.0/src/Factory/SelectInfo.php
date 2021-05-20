<?php

declare(strict_types=1);

namespace Pollen\Filebrowser\Factory;

use BadMethodCallException;
use Exception;
use League\Flysystem\StorageAttributes;
use Pollen\Filebrowser\Filebrowser;
use Throwable;

/**
 * @mixin AbstractResourceInfo
 * @mixin PathInfo
 * @mixin DirInfo
 */
class SelectInfo implements SelectInfoInterface
{
    use FilebrowserAwareTrait;

    /**
     * @var string
     */
    protected $path;

    /**
     * Instance de la ressource associée.
     * @var StorageAttributes
     */
    protected $resource;

    /**
     * @var ResourceInfoInterface|DirInfoInterface|FileInfoInterface
     */
    protected $info;

    /**
     * @param string $path
     * @param Filebrowser $filebrowser
     */
    public function __construct(string $path, Filebrowser $filebrowser)
    {
        $this->path = $path;
        $this->setFilebrowser($filebrowser);

        $this->resource = $this->filebrowser()->filesystem()->getStorageAttributes($path);

        if ($this->resource->isDir()) {
            $this->info = new DirInfo($this->resource, $this->filebrowser());
        } else {
            $this->info = new FileInfo($this->resource, $this->filebrowser());
        }
    }

    /**
     * Appel des méthodes de la resource associée.
     *
     * @param string $method
     * @param array $arguments
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function __call(string $method, array $arguments)
    {
        try {
            return $this->info->{$method}(...$arguments);
        } catch (Exception $e) {
            throw $e;
        } catch (Throwable $e) {
            throw new BadMethodCallException(
                sprintf(
                    'Delegate [%s] method call [%s] throws an exception: %s',
                    __CLASS__,
                    $method,
                    $e->getMessage()
                ), 0, $e
            );
        }
    }
}