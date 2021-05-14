<?php

declare(strict_types=1);

namespace Pollen\Filebrowser;

use Pollen\Container\BootableServiceProvider;

class FilebrowserServiceProvider extends BootableServiceProvider
{
    /**
     * Liste des services fournis.
     * @var array
     */
    protected $provides = [
        FilebrowserManagerInterface::class,
    ];

    /**
     * @inheritDoc
     */
    public function register(): void
    {
        $this->getContainer()->share(FilebrowserManagerInterface::class, function () {
            return new FilebrowserManager([], $this->getContainer());
        });
    }
}