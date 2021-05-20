<?php

declare(strict_types=1);

namespace Pollen\Filebrowser\Factory;

interface PathInfoInterface extends FactoryInterface
{
    /**
     * Instance du répertoire associé.
     *
     * @return DirInfoInterface
     */
    public function dirInfo(): DirInfoInterface;

    /**
     * Instance du fichier associé.
     *
     * @return FileInfoInterface|null
     */
    public function fileInfo(): ?FileInfoInterface;

    /**
     * Chemin relatif vers le repertoire associé à la resource.
     *
     * @return string
     */
    public function dirname(): string;

    /**
     * Chemin relatif vers la ressource.
     *
     * @return string
     */
    public function path(): string;
}