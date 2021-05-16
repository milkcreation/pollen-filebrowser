<?php

declare(strict_types=1);

namespace Pollen\Filebrowser;

Interface FilebrowserProxyInterface
{
    /**
     * Instance du gestionnaire de navigateurs de fichiers.
     *
     * @param string|null $name
     *
     * @return FilebrowserManagerInterface|FilebrowserInterface
     */
    public function filebrowser(?string $name = null);

    /**
     * Définition du gestionnaire de navigateurs de fichiers.
     *
     * @param FilebrowserManagerInterface $filebrowserManager
     *
     * @return void
     */
    public function setFilebrowserManager(FilebrowserManagerInterface $filebrowserManager): void;
}