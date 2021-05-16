<?php

declare(strict_types=1);

namespace Pollen\Filebrowser\Factory;

use Pollen\Filebrowser\Exception\FilebrowserNotFound;
use Pollen\Filebrowser\FilebrowserInterface;

trait FilebrowserAwareTrait
{
    /**
     * @var FilebrowserInterface
     */
    protected $filebrowser;

    /**
     * @return FilebrowserInterface
     */
    public function filebrowser(): FilebrowserInterface
    {
        if ($this->filebrowser instanceof FilebrowserInterface) {
            return  $this->filebrowser;
        }

        throw new FilebrowserNotFound();
    }

    /**
     * @param FilebrowserInterface $filebrowser
     *
     * @return void
     */
    public function setFilebrowser(FilebrowserInterface $filebrowser): void
    {
        $this->filebrowser = $filebrowser;
    }
}