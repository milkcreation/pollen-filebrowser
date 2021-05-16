<?php

declare(strict_types=1);

namespace Pollen\Filebrowser\Factory;

use Pollen\Http\JsonResponseInterface;

/**
 * @mixin \Pollen\Routing\BaseController
 */
interface ControllerInterface extends FactoryInterface
{
    /**
     * @return JsonResponseInterface
     */
    public function xhrBrowsePath(): JsonResponseInterface;

    /**
     * @return JsonResponseInterface
     */
    public function xhrCreateDir(): JsonResponseInterface;

    /**
     * @return JsonResponseInterface
     */
    public function xhrDeleteDir(): JsonResponseInterface;

    /**
     * @return JsonResponseInterface
     */
    public function xhrDeleteFile(): JsonResponseInterface;

    /**
     * @return JsonResponseInterface
     */
    public function xhrDownloadFile(): JsonResponseInterface;

    /**
     * @return JsonResponseInterface
     */
    public function xhrUploadFiles(): JsonResponseInterface;

    /**
     * @return JsonResponseInterface
     */
    public function xhrRenameDir(): JsonResponseInterface;

    /**
     * @return JsonResponseInterface
     */
    public function xhrRenameFile(): JsonResponseInterface;
}
