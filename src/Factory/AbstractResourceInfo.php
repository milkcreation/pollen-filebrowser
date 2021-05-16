<?php

declare(strict_types=1);

namespace Pollen\Filebrowser\Factory;

use League\Flysystem\FilesystemException;
use League\Flysystem\StorageAttributes;
use Pollen\Filesystem\LocalFilesystemInterface;
use Pollen\Support\DateTime;

abstract class AbstractResourceInfo implements ResourceInfoInterface
{
    use FilebrowserAwareTrait;

    /**
     * Instance de la ressource associée.
     * @var StorageAttributes
     */
    protected $resource;

    /**
     * @param StorageAttributes $resource
     */
    public function __construct(StorageAttributes $resource)
    {
        $this->resource = $resource;
    }

    /**
     * @inheritDoc
     */
    public function getBasename(string $suffix = ''): string
    {
        return basename($this->getRelPath(), $suffix);
    }

    /**
     * @inheritDoc
     */
    public function getHumanDate(string $format = 'Y-m-d'): ?string
    {
        return ($datetime = new DateTime($this->getMTime())) ? $datetime->format($format) : null;
    }

    /**
     * @inheritDoc
     */
    public function getIcon(): string
    {
        return '';
    }

    /**
     * @inheritDoc
     */
    public function getMTime(): int
    {
        try {
            return $this->filebrowser()->filesystem()->lastModified($this->getRelPath());
        } catch (FilesystemException $e) {
            return 0;
        }
    }

    /**
     * @inheritDoc
     */
    public function getRelPath(): string
    {
        return $this->resource->path();
    }

    /**
     * @inheritDoc
     */
    public function isDir(): bool
    {
        return $this->resource->isDir();
    }

    /**
     * @inheritDoc
     */
    public function isFile(): bool
    {
        return $this->resource->isFile();
    }

    /**
     * @inheritDoc
     */
    public function isLocal(): bool
    {
        return $this->filebrowser()->filesystem() instanceof LocalFilesystemInterface;
    }
}