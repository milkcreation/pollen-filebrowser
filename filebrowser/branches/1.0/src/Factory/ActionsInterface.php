<?php

declare(strict_types=1);

namespace Pollen\Filebrowser\Factory;

use Exception;
use Pollen\Http\BinaryFileResponseInterface;
use Pollen\Http\RequestInterface;
use Pollen\Support\Proxy\PartialProxyInterface;
use Pollen\Support\Proxy\ValidatorProxyInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface ActionsInterface extends FactoryInterface, PartialProxyInterface, ValidatorProxyInterface
{
    /**
     * Traitement de la liste des arguments de requête HTTP associé à une action.
     *
     * @param string $action
     * @param RequestInterface $request
     *
     * @return array
     *
     * @throws Exception
     */
    public function parseRequestArgs(string $action, RequestInterface $request): array;

    /**
     * @param string $path
     *
     * @return array
     */
    public function browse(string $path): array;

    /**
     * @param string $path
     *
     * @return array
     */
    public function select(string $path = ''): array;

    /**
     * @param string $path
     * @param string $name
     *
     * @return array
     */
    public function createDir(string $path, string $name): array;

    /**
     *  @param string $path
     *
     * @return array
     */
    public function delete(string $path): array;

    /**
     * @param string $path
     *
     * @return BinaryFileResponseInterface
     */
    public function downloadFile(string $path): BinaryFileResponseInterface;

    /**
     * @param string $path
     * @param UploadedFile $file
     * @param string|null $fullPath
     * @return array
     */
    public function uploadFile(string $path, UploadedFile $file, ?string $fullPath = null): array;

    /**
     * @param string $path
     * @param string $name
     *
     * @return array
     */
    public function rename(string $path, string $name): array;
}
