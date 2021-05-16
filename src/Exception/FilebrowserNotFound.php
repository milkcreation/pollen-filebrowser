<?php

declare(strict_types=1);

namespace Pollen\Filebrowser\Exception;

use InvalidArgumentException;
use Throwable;

class FilebrowserNotFound extends InvalidArgumentException
{
    public function __construct(?string $name = null, string $message = "", int $code = 0, Throwable $previous = null)
    {
        if (empty($message)) {
            if ($name !== null) {
                $message = sprintf('Could not retrieve Filebrowser [%s].', $name);
            } else {
                $message = 'Could not retrieve Filebrowser.';
            }
        }

        parent::__construct($message, $code, $previous);
    }
}