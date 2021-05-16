<?php

declare(strict_types=1);

namespace Pollen\Filebrowser\Factory;

use ArrayAccess;
use Countable;
use IteratorAggregate;

interface BreadcrumbInterface extends FactoryInterface, ArrayAccess, Countable, IteratorAggregate
{
    /**
     * Récupération la liste de tous les éléments.
     *
     * @return array
     */
    public function all(): array;

    /**
     * Supprime la liste des élements.
     *
     * @return void
     */
    public function clear(): void;

    /**
     * Retrouve la liste des éléments relatif à un chemin.
     *
     * @param string $path
     *
     * @return void
     */
    public function fetch(string $path): void;

    /**
     * Récupére le contenu du lien vers la page d'accueil.
     *
     * @return string
     */
    public function getHomeContent(): string;
}