<?php

declare(strict_types=1);

namespace Pollen\Filebrowser\Factory;

interface ResourceInfoInterface extends FactoryInterface
{
    /**
     * Récupération du nom de base du fichier.
     *
     * @param string $suffix
     *
     * @return string
     */
    public function getBasename(string $suffix = ''): string;

    /**
     * Récupération du chemin relatif vers le répertoire parent.
     *
     * @return string
     */
    public function getDirname(): string;

    /**
     * Récupération de la date formatée.
     *
     * @param string $format
     *
     * @return string
     */
    public function getHumanDate(string $format = 'Y-m-d'): ?string;

    /**
     * Récupération de type de ressource qualifiée.
     *
     * @return string
     */
    public function getHumanType(): string;

    /**
     * Récupération de l'icône représentative.
     *
     * @param array $attrs
     * @param string $placeholder
     *
     * @return string
     */
    public function getIcon(array $attrs = [], string $placeholder = '_default'): string;

    /**
     * Récupération de la date de dernière modification.
     *
     * @return int
     */
    public function getMTime(): int;

    /**
     * Récupération du chemin relatif vers le fichier.
     *
     * @return string
     */
    public function getRelPath(): string;

    /**
     * Vérifie si la ressource associée est de type répertoire.
     *
     * @return bool
     */
    public function isDir(): bool;

    /**
     * Vérifie si la ressource associée est de type fichier.
     *
     * @return bool
     */
    public function isFile(): bool;

    /**
     * Vérifie si la ressource appartient à un système de fichier local.
     *
     * @return bool
     */
    public function isLocal(): bool;

    /**
     * Vérifie si la ressource est sélectionnée.
     *
     * @return bool
     */
    public function isSelected(): bool;
}