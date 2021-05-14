<?php

declare(strict_types=1);

namespace Pollen\Filebrowser;

use Pollen\Support\Concerns\ConfigBagAwareTraitInterface;
use Pollen\Support\Concerns\ResourcesAwareTraitInterface;
use Pollen\Support\Proxy\ContainerProxyInterface;

interface FilebrowserManagerInterface extends
    ConfigBagAwareTraitInterface,
    ContainerProxyInterface,
    ResourcesAwareTraitInterface
{
    /**
     * Chargement.
     *
     * @return void
     */
    public function boot(): void;
}