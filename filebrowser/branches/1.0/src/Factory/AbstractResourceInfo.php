<?php

declare(strict_types=1);

namespace Pollen\Filebrowser\Factory;

use League\Flysystem\FilesystemException;
use League\Flysystem\StorageAttributes;
use Pollen\Filebrowser\FilebrowserInterface;
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
     * @param FilebrowserInterface $filebrowser
     */
    public function __construct(StorageAttributes $resource, FilebrowserInterface $filebrowser)
    {
        $this->resource = $resource;
        $this->setFilebrowser($filebrowser);
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
    public function getDirname(): string
    {
        $dirname = dirname($this->getRelPath());

        if ($dirname === '.') {
            return '/';
        }

        return $dirname;
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
    public function getHumanType(): string
    {
        if ($this->isDir()) {
            return 'répertoire';
        }
        if ($this->isFile()) {
            return 'fichier';
        }
        return '';
    }

    /**
     * @inheritDoc
     */
    public function getIcon(array $attrs = [], string $placeholder = '_default'): string
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

    /**
     * @inheritDoc
     */
    public function isSelected(): bool
    {
        return ($selected = $this->filebrowser()->getSelectedInfo()) && $selected->getRelPath() === $this->getRelPath();
    }
}