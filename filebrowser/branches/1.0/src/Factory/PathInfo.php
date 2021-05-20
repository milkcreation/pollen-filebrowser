<?php

declare(strict_types=1);

namespace Pollen\Filebrowser\Factory;

use League\Flysystem\StorageAttributes;
use Pollen\Filebrowser\Filebrowser;
use Pollen\Support\Filesystem as fs;

class PathInfo implements PathInfoInterface
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
     * @var DirInfoInterface
     */
    protected $dirInfo;

    /**
     * @var FileInfoInterface
     */
    protected $fileInfo;

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
            $this->dirInfo = new DirInfo($this->resource, $this->filebrowser());
        } else {
            $this->fileInfo = new FileInfo($this->resource, $this->filebrowser());

            $dirPath = dirname($this->fileInfo->getRelPath());
            $dirResource = $this->filebrowser()->filesystem()->getStorageAttributes($dirPath);
            $this->dirInfo = new DirInfo($dirResource, $this->filebrowser());
        }
    }

    /**
     * @inheritDoc
     */
    public function dirInfo(): DirInfoInterface
    {
        return $this->dirInfo;
    }

    /**
     * @inheritDoc
     */
    public function fileInfo(): ?FileInfoInterface
    {
        return $this->fileInfo;
    }

    /**
     * @inheritDoc
     */
    public function dirname(): string
    {
        return fs::normalizePath('/' . $this->dirInfo()->getRelPath());
    }

    /**
     * @inheritDoc
     */
    public function path(): string
    {
        return $this->path;
    }
}