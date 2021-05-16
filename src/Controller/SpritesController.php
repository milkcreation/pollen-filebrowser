<?php

declare(strict_types=1);

namespace Pollen\Filebrowser\Controller;

use Pollen\Http\ResponseInterface;
use Pollen\Support\Filesystem as fs;
use Pollen\Routing\Exception\NotFoundException;

class SpritesController extends AbstractBaseController
{
    /**
     * @param string $svg brands.svg|regular.svg|solid.svg
     *
     * @throws NotFoundException
     */
    public function __invoke(string $svg): ResponseInterface
    {
        if (defined('VENDOR_PATH')) {
            $path = VENDOR_PATH . fs::DS . fs::normalizePath("fortawesome/font-awesome/sprites/$svg");
        }

        if (!isset($path) || !file_exists($path)) {
            $path = $this->filebrowser()->resources("assets/src/img/$svg");
            if (!file_exists($path)) {
                throw new NotFoundException();
            }
        }

        $content = file_get_contents($path);

        return $this->response($content, 200, ['Content-Type' => 'image/svg+xml']);
    }
}