<?php

declare(strict_types=1);

namespace Pollen\Filebrowser\Exception;

use RuntimeException;
use Throwable;

class FilebrowserUnresolvable extends RuntimeException
{
    public function __construct(?string $name = null, string $message = "", int $code = 0, Throwable $previous = null)
    {
        if (empty($message)) {
            if ($name !== null) {
                $message = sprintf('Could not resolve Filebrowser [%s]', $name);
            } else {
                $message = 'Could not resolve Filebrowser';
            }
        }

        parent::__construct($message, $code, $previous);
    }
}