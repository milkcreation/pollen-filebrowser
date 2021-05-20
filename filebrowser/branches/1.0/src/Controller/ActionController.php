<?php

declare(strict_types=1);

namespace Pollen\Filebrowser\Controller;

use Pollen\Filebrowser\Exception\FilebrowserActionNotice;
use Pollen\Http\JsonResponse;
use Pollen\Http\ResponseInterface;
use Pollen\Routing\Exception\NotFoundException;
use Pollen\Support\Proxy\PartialProxy;
use Throwable;

class ActionController extends AbstractBaseController
{
    use PartialProxy;

    /**
     * @param string $name
     *
     * @return ResponseInterface
     *
     * @throws NotFoundException
     */
    public function __invoke(string $name): ResponseInterface
    {
       try {
            $filebrowser = $this->filebrowser($name);
        } catch (Throwable $e) {
            throw new NotFoundException();
        }

        if (!$action = $this->httpRequest()->input()->pull('action')) {
            throw new NotFoundException();
        }

        try {
            $response = $filebrowser->doAction($action, $this->httpRequest());

            if ($response instanceof ResponseInterface) {
                return $response;
            }

            return new JsonResponse([
                'success' => true,
                'data' => $response
            ]);
        } catch(FilebrowserActionNotice $e) {
            return new JsonResponse([
                'success' => false,
                'data'    => $this->notice($e->getMessage(), $e->getType())
            ]);
        } catch(Throwable $e) {
            throw new NotFoundException();
        }
    }

    /**
     * Message de notification.
     *
     * @param string $message
     * @param string $type error|success|info|warning
     * @param array $attrs
     *
     * @return string
     */
    protected function notice(string $message, string $type = 'error', array $attrs = []): string
    {
        return $this->partial('notice', array_merge([
          'attrs'   => [
              'class' => '%s Filebrowser-notice Filebrowser-notice--'. $type
          ],
          'content' => $message,
          'dismiss' => true,
          'timeout' => 2000,
          'type'    => $type
      ], $attrs))->render();
    }
}