<?php

declare(strict_types=1);

namespace Pollen\Filebrowser;

use Pollen\Routing\RouteInterface;
use Pollen\Support\Concerns\BootableTraitInterface;
use Pollen\Support\Concerns\ConfigBagAwareTraitInterface;
use Pollen\Support\Concerns\ResourcesAwareTraitInterface;
use Pollen\Support\Proxy\ContainerProxyInterface;
use Pollen\Support\Proxy\RouterProxyInterface;
use Pollen\Support\Proxy\StorageProxyInterface;

interface FilebrowserManagerInterface extends
    BootableTraitInterface,
    ConfigBagAwareTraitInterface,
    ContainerProxyInterface,
    ResourcesAwareTraitInterface,
    RouterProxyInterface,
    StorageProxyInterface
{
    /**
     * Chargement.
     *
     * @return void
     */
    public function boot(): void;

    /**
     * Ajout d'un navigateur de fichier.
     *
     * @param string $name
     * @param FilebrowserInterface $filebrowser
     *
     * @return FilebrowserInterface
     */
    public function addBrowser(string $name, FilebrowserInterface $filebrowser): FilebrowserInterface;

    /**
     * Récupération de l'instance d'un navigateur de fichiers déclaré.
     *
     * @param string $name
     *
     * @return FilebrowserInterface
     */
    public function get(string $name): FilebrowserInterface;

    /**
     * Récupération d'une route.
     *
     * @param string $endpoint
     *
     * @return RouteInterface
     */
    public function getRoute(string $endpoint): RouteInterface;

    /**
     * Récupération de l'url vers une route.
     *
     * @param string $endpoint
     * @param array $args
     * @param bool $isAbsolute
     *
     * @return string
     */
    public function getRouteUrl(string $endpoint, array $args = [], bool $isAbsolute = false): string;

    /**
     * Déclaration d'un navigateur de fichier.
     *
     * @param string $name
     * @param string|array|FilebrowserInterface $filebrowserDef
     *
     * @return FilebrowserManagerInterface
     */
    public function registerBrowser(string $name, $filebrowserDef): FilebrowserManagerInterface;
}