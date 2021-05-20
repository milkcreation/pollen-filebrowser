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
     * Récupération du nom de qualification de l'icône de remplacement par défaut.
     *
     * @return string
     */
    public function getDefaultPlaceholderName(): string;

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
     * @param array $attrs
     * @param string|null $placeholder
     *
     * @return string|null
     */
    public function fileRender(FileInfoInterface $file, array $attrs = [], ?string $placeholder = 'file'): string;

    /**
     * Récupération du rendu d'une icône.
     *
     * @param string $name
     * @param array $attrs
     * @param string|null $placeholder
     *
     * @return string|null
     */
    public function render(string $name, array $attrs = [], ?string  $placeholder = '_default'): string;
}