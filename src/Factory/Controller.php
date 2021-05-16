<?php

declare(strict_types=1);

namespace Pollen\Filebrowser\Factory;

use Pollen\Http\JsonResponse;
use Pollen\Http\JsonResponseInterface;
use Pollen\Routing\BaseController;

class Controller extends BaseController implements ControllerInterface
{
    use FilebrowserAwareTrait;

    /**
     * @inheritDoc
     */
    public function xhrBrowsePath(): JsonResponseInterface
    {
        return new JsonResponse(
            [
                'success' => true,
                'datas'   => '',
            ]
        );
    }

    /**
     * @inheritDoc
     */
    public function xhrCreateDir(): JsonResponseInterface
    {
        return new JsonResponse(
            [
                'success' => true,
                'datas'   => '',
            ]
        );
    }

    /**
     * @inheritDoc
     */
    public function xhrDeleteDir(): JsonResponseInterface
    {
        return new JsonResponse(
            [
                'success' => true,
                'datas'   => '',
            ]
        );
    }

    /**
     * @inheritDoc
     */
    public function xhrDeleteFile(): JsonResponseInterface
    {
        return new JsonResponse(
            [
                'success' => true,
                'datas'   => '',
            ]
        );
    }

    /**
     * @inheritDoc
     */
    public function xhrDownloadFile(): JsonResponseInterface
    {
        return new JsonResponse(
            [
                'success' => true,
                'datas'   => '',
            ]
        );
    }

    /**
     * @inheritDoc
     */
    public function xhrUploadFiles(): JsonResponseInterface
    {
        return new JsonResponse(
            [
                'success' => true,
                'datas'   => '',
            ]
        );
    }

    /**
     * @inheritDoc
     */
    public function xhrRenameDir(): JsonResponseInterface
    {
        return new JsonResponse(
            [
                'success' => true,
                'datas'   => '',
            ]
        );
    }

    /**
     * @inheritDoc
     */
    public function xhrRenameFile(): JsonResponseInterface
    {
        return new JsonResponse(
            [
                'success' => true,
                'datas'   => '',
            ]
        );
    }
}
