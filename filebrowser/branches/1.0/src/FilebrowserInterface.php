<?php

declare(strict_types=1);

namespace Pollen\Filebrowser;

use Pollen\Filebrowser\Factory\FileInfoInterface;
use Pollen\Filebrowser\Factory\PathInfoInterface;
use Pollen\Filebrowser\Factory\SelectInfoInterface;
use Pollen\Filesystem\FilesystemInterface;
use Pollen\Http\RequestInterface;
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
     * Execution d'une action.
     *
     * @param string $actionName
     * @param RequestInterface $request
     *
     * @return mixed
     */
    public function doAction(string $actionName, RequestInterface $request);

    /**
     * Instance du gestionnaire de fichiers associé.
     *
     * @return FilesystemInterface
     */
    public function filesystem(): FilesystemInterface;

    /**
     * Récupération de l'url de déclenchement d'une action.
     *
     * @param string|null $action
     * @param array $args
     *
     * @return string
     */
    public function getActionUrl(?string $action = null, array $args = []): string;

    /**
     * Récupération du rendu d'une icône de fichier.
     *
     * @param FileInfoInterface $file
     * @param array $attrs
     * @param string|null $placeholder
     *
     * @return string
     */
    public function getFileIcon(FileInfoInterface $file, array $attrs = [], ?string $placeholder = 'file'): string;

    /**
     * Récupération du rendu d'une icône.
     *
     * @param string $name
     * @param array $attrs
     * @param string|null $placeholder
     *
     * @return string
     */
    public function getIcon(string $name, array $attrs = [], ?string $placeholder = '_default'): string;

    /**
     * Récupération du nom de qualification.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Récupération du chemin relatif vers la ressource courante (répertoire ou fichier)
     *
     * @return string
     */
    public function getPath(): string;

    /**
     * Récupération de l'instance de la ressource courante (répertoire ou fichier)
     *
     * @return PathInfoInterface
     */
    public function getPathInfo(): PathInfoInterface;

    /**
     * Récupération du chemin relatif vers la ressource sélectionnée (répertoire ou fichier)
     *
     * @return string|null
     */
    public function getSelected(): ?string;

    /**
     * Récupération de l'instance de la ressource sélectionnée (répertoire ou fichier)
     *
     * @return SelectInfoInterface|null
     */
    public function getSelectedInfo(): ?SelectInfoInterface;

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
     * Traitement des paramètres de rendu de l'affichage.
     *
     * @return void
     */
    public function renderParse(): void;

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
     * Définition du chemin relatif vers la ressource courante (répertoire ou fichier)
     *
     * @param string $path
     *
     * @return static
     */
    public function setPath(string $path): FilebrowserInterface;

    /**
     * Définition du chemin relatif vers la ressource sélectionnée (répertoire ou fichier)
     *
     * @param string|null $path
     *
     * @return static
     */
    public function setSelected(?string $path = null): FilebrowserInterface;

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