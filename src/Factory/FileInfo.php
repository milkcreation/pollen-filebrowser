<?php

declare(strict_types=1);

namespace Pollen\Filebrowser\Factory;

use League\Flysystem\FilesystemException;
use League\Flysystem\FileAttributes;
use SplFileInfo;

class FileInfo extends AbstractResourceInfo implements FileInfoInterface
{
    /**
     * @var FileAttributes
     */
    protected $resource;

    /**
     * @inheritDoc
     */
    public function getIcon(array $attrs = [], string $placeholder = 'file'): string
    {
        return $this->filebrowser()->getFileIcon($this, $attrs, $placeholder);
    }

    /**
     * @inheritDoc
     */
    public function getHumanSize(int $decimals = 2): ?string
    {
        if ($bytes = $this->getSize()) {
            $sz = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
            $factor = floor((strlen((string)$bytes) - 1) / 3);

            return sprintf("%.{$decimals}f %s", $bytes / (1024 ** $factor), ($sz[(int)$factor] ?? ''));
        }

        return null;
    }

    /**
     * @inheritDoc
     */
    public function getDownloadUrl(): string
    {
        return $this->filebrowser()->getActionUrl('downloadFile', ['path' => $this->getRelPath()]);
    }

    /**
     * @inheritDoc
     */
    public function getExtension(): string
    {
        return $this->getSplFileInfo()->getExtension();
    }

    /**
     * @inheritDoc
     */
    public function getMimeType(): string
    {
        try {
            return $this->filebrowser()->filesystem()->mimeType($this->getRelPath());
        } catch (FilesystemException $e) {
            return '';
        }
    }

    /**
     * @inheritDoc
     */
    public function getSize(): int
    {
        try {
            return $this->filebrowser()->filesystem()->fileSize($this->getRelPath());
        } catch (FilesystemException $e) {
            return 0;
        }
    }

    /**
     * @inheritDoc
     */
    public function getSplFileInfo(): SplFileInfo
    {
        return $this->filebrowser()->filesystem()->getSplFileInfo($this->getRelPath());
    }
}