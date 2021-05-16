<?php

declare(strict_types=1);

namespace Pollen\Filebrowser\Factory;

interface IconCollectionInterface extends FactoryInterface
{
    /**
     * Récupération de l'icône associé.
     *
     * @param string $name
     *
     * @return string|null
     */
    public function get(string $name): ?string;

    /**
     * Récupération de l'icône associé à un type MIME.
     *
     * @param string $mimeType
     *
     * @return string
     */
    public function mimeTypeGet(string $mimeType): ?string;

    /**
     * Récupération du rendu d'une icône de fichier.
     *
     * @param FileInfoInterface $file
     *
     * @return string|null
     */
    public function fileRender(FileInfoInterface $file): string;

    /**
     * Récupération du rendu d'une icône.
     *
     * @param string $name
     *
     * @return string|null
     */
    public function render(string $name): string;
}