<?php

declare(strict_types=1);

namespace Pollen\Filebrowser\Factory;

use League\Flysystem\DirectoryAttributes;

class DirInfo extends AbstractResourceInfo implements DirInfoInterface
{
    /**
     * @var DirectoryAttributes
     */
    protected $resource;

    /**
     * @inheritDoc
     */
    public function getIcon(): string
    {
        return $this->filebrowser()->getIcon('directory');
    }
}