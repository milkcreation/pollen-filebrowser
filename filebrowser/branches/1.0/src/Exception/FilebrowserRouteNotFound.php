<?php

declare(strict_types=1);

namespace Pollen\Filebrowser\Exception;

use InvalidArgumentException;
use Throwable;

class FilebrowserRouteNotFound extends InvalidArgumentException implements FilebrowserException
{
    public function __construct(?string $endpoint = null, string $message = "", int $code = 0, Throwable $previous = null)
    {
        if (empty($message)) {
            if ($endpoint !== null) {
                $message = sprintf('Could not retrieve Filebrowser Route for endpoint [%s].', $endpoint);
            } else {
                $message = 'Could not retrieve Filebrowser Route.';
            }
        }

        parent::__construct($message, $code, $previous);
    }
}