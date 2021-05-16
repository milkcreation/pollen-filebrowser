<?php

declare(strict_types=1);

namespace Pollen\Filebrowser;

use Pollen\Filebrowser\Factory\FileCollectorInterface;
use Pollen\Filebrowser\Factory\FileInfoInterface;
use Pollen\Filesystem\FilesystemInterface;
use Pollen\Support\Concerns\BuildableTraitInterface;
use Pollen\Support\Concerns\ParamsBagAwareTraitInterface;
use Pollen\View\ViewEngineInterface;

interface FilebrowserInterface extends BuildableTraitInterface, ParamsBagAwareTraitInterface
{
    /**
     * Résolution d'affichage de la classe en tant que rendu du navigateur de fichiers.
     *
     * @return string
     */
    public function __toString(): string;

    /**
     * Initialisation.
     *
     * @return void
     */
    public function build(): void;

    /**
     * Instance du gestionnaire de fichiers associé.
     *
     * @return FilesystemInterface
     */
    public function filesystem(): FilesystemInterface;

    /**
     * Récupération de l'instance des fichiers du répertoire courant.
     *
     * @return FileCollectorInterface
     */
    public function getCurrentFiles(): FileCollectorInterface;

    /**
     * Récupération du chemin relatif vers la ressource courante (répertoire ou fichier)
     *
     * @return static
     */
    public function getCurrentPath(): string;

    /**
     * Récupération du rendu d'une icône de fichier.
     *
     * @param FileInfoInterface $file
     *
     * @return string
     */
    public function getFileIcon(FileInfoInterface $file): string;

    /**
     * Récupération du rendu d'une icône.
     *
     * @param string $name
     *
     * @return string
     */
    public function getIcon(string $name): string;

    /**
     * Récupération du nom de qualification.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Instance du gestionnaire de navigateurs de fichiers
     *
     * @return FilebrowserManagerInterface
     */
    public function manager(): FilebrowserManagerInterface;

    /**
     * Rendu d'affichage du navigateur de fichiers.
     *
     * @return string
     */
    public function render(): string;

    /**
     * Définition du chemin relatif vers la ressource courante (répertoire ou fichier)
     *
     * @param string $path
     *
     * @return static
     */
    public function setCurrentPath(string $path): FilebrowserInterface;

    /**
     * Définition du gestionnaire de navigateurs de fichiers
     *
     * @param FilebrowserManagerInterface $manager
     *
     * @return static
     */
    public function setManager(FilebrowserManagerInterface $manager): FilebrowserInterface;

    /**
     * Définition du nom de qualification.
     *
     * @param string $name
     *
     * @return static
     */
    public function setName(string $name): FilebrowserInterface;

    /**
     * Définition de l'instance du moteur d'affichage.
     *
     * @param ViewEngineInterface $viewEngine
     *
     * @return static
     */
    public function setViewEngine(ViewEngineInterface $viewEngine): FilebrowserInterface;

    /**
     * Rendu d'un gabarit d'affichage.
     *
     * @param string $name
     * @param array $datas
     *
     * @return string
     */
    public function view(string $name, array $datas = []): string;
}