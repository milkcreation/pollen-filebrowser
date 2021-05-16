<?php

declare(strict_types=1);

namespace Pollen\Filebrowser\Factory;

use League\Flysystem\DirectoryAttributes;
use League\Flysystem\FileAttributes;
use League\Flysystem\FilesystemException;
use Pollen\Filesystem\FilesystemInterface;
use Pollen\Filesystem\LocalFilesystemInterface;

class FileCollector implements FileCollectorInterface
{
    use FilebrowserAwareTrait;

    /**
     * @var int
     */
    private $offset = 0;

    /**
     * @var FileInfo[]|array
     */
    protected $files = [];

    /**
     * @inheritDoc
     */
    public function all(): array
    {
        return $this->files;
    }

    /**
     * @inheritDoc
     */
    public function clear(): void
    {
        $this->files = [];
        $this->offset = 0;
    }

    /**
     * @inheritDoc
     */
    public function fetch(string $path, bool $recursive = false): FileCollectorInterface
    {
        $this->clear();

        try {
            $resources = iterator_to_array($this->filesystem()->listContents($path, $recursive));

            foreach ($resources as $resource) {
                if ($resource instanceof FileAttributes) {
                    $file = new FileInfo($resource);
                } elseif ($resource instanceof DirectoryAttributes) {
                    $file = new DirInfo($resource);
                } else {
                    continue;
                }

                $file->setFilebrowser($this->filebrowser());

                $this->files[] = $file;
            }
        } catch (FilesystemException $exception) {
            // handle the error
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function has(): bool
    {
        return !empty($this->files);
    }

    /**
     * @inheritDoc
     */
    public function filesystem(): FilesystemInterface
    {
        return $this->filebrowser()->filesystem();
    }

    /**
     * @inheritDoc
     */
    public function rewind(): void
    {
        $this->offset = 0;
    }

    /**
     * @inheritDoc
     *
     * @return FileInfoInterface|DirInfoInterface
     */
    public function current(): ?ResourceInfoInterface
    {
        return $this->files[$this->offset] ?? null;
    }

    /**
     * @inheritDoc
     */
    public function key(): int
    {
        return $this->offset;
    }

    /**
     * @inheritDoc
     */
    public function next(): void
    {
        ++$this->offset;
    }

    /**
     * @inheritDoc
     */
    public function valid(): bool
    {
        return isset($this->files[$this->offset]);
    }
}