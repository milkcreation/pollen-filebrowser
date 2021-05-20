<?php

declare(strict_types=1);

namespace Pollen\Filebrowser\Controller;

use Pollen\Http\ResponseInterface;
use Pollen\Support\DateTime;
use Pollen\Support\Filesystem as fs;
use Pollen\Routing\Exception\NotFoundException;
use SplFileInfo;

class SpriteController extends AbstractBaseController
{
    /**
     * @param string $svg brands.svg|regular.svg|solid.svg
     *
     * @return ResponseInterface
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

        $response = $this->response($content, 200, ['Content-Type' => 'image/svg+xml']);

        $fileInfo = new SplFileInfo($path);
        $response->setCache(
            [
                'must_revalidate'  => false,
                'no_cache'         => false,
                'no_store'         => false,
                'no_transform'     => false,
                'public'           => true,
                'private'          => false,
                'proxy_revalidate' => false,
                'max_age'          => 3600,
                's_maxage'         => 3600,
                'immutable'        => true,
                'last_modified'    => new DateTime($fileInfo->getMTime()),
            ]
        );

        return $response;
    }
}