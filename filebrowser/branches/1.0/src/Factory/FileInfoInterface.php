<?php

declare(strict_types=1);

namespace Pollen\Filebrowser\Factory;

use SplFileInfo;

interface FileInfoInterface extends ResourceInfoInterface
{
    /**
     * Récupération de l'url de téléchargement du fichier.
     *
     * @return string
     */
    public function getDownloadUrl(): string;

    /**
     * Récupération de l'extension du fichier.
     *
     * @return string
     */
    public function getExtension(): string;

    /**
     * Récupération de la taille du fichier formatée.
     *
     * @param int $decimals
     *
     * @return string
     */
    public function getHumanSize(int $decimals = 2): ?string;

    /**
     * Récupération du type Mime du fichier.
     *
     * @return string|null
     */
    public function getMimeType(): string;

    /**
     * Récupération de la taille du fichier.
     *
     * @return int
     */
    public function getSize(): int;

    /**
     * Récupération de l'instance des informations du fichier.
     *
     * @return SplFileInfo
     */
    public function getSplFileInfo(): SplFileInfo;
}