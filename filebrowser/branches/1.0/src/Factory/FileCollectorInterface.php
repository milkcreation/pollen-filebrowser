<?php

declare(strict_types=1);

namespace Pollen\Filebrowser\Factory;

use Iterator;
use Pollen\Filesystem\FilesystemInterface;

interface FileCollectorInterface extends FactoryInterface, Iterator
{
    /**
     * Récupération de la liste des fichiers.
     *
     * @return FileInfoInterface[]|array
     */
    public function all(): array;

    /**
     * Supprime la liste des fichiers.
     *
     * @return void
     */
    public function clear(): void;

    /**
     * Retrouve la liste des resources associées à un chemin.
     *
     * @param string $path
     * @param bool $recursive
     *
     * @return static
     */
    public function fetch(string $path, bool $recursive = false): FileCollectorInterface;

    /**
     * Vérifie l'existance de fichier.
     *
     * @return bool
     */
    public function has(): bool;

    /**
     * Instance du gestionnaire de fichier associé.
     *
     * @return FilesystemInterface
     */
    public function filesystem(): FilesystemInterface;
}