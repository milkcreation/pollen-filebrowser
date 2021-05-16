<?php

declare(strict_types=1);

namespace Pollen\Filebrowser\Factory;

interface FileInfoInterface extends ResourceInfoInterface
{
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
}