<?php

declare(strict_types=1);

namespace Pollen\Filebrowser\Factory;

use Pollen\Filebrowser\FilebrowserInterface;

interface FactoryInterface
{
    /**
     * @return FilebrowserInterface
     */
    public function filebrowser(): FilebrowserInterface;

    /**
     * @param FilebrowserInterface $filebrowser
     *
     * @return void
     */
    public function setFilebrowser(FilebrowserInterface $filebrowser): void;
}