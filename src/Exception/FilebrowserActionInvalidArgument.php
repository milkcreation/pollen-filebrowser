<?php

declare(strict_types=1);

namespace Pollen\Filebrowser\Exception;

use InvalidArgumentException;
use Throwable;

class FilebrowserActionInvalidArgument extends InvalidArgumentException implements FilebrowserException
{
    /**
     * @param string|null $name
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(?string $name = null, string $message = '', int $code = 0, Throwable $previous = null)
    {
        if (empty($message)) {
            if ($name !== null) {
                $message = sprintf('Request arguments of Filebrowser Action [%s] invalid.', $name);
            } else {
                $message = 'Request arguments of Filebrowser Action invalid.';
            }
        }

        parent::__construct($message, $code, $previous);
    }
}