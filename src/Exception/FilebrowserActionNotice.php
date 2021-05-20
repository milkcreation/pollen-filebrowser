<?php

declare(strict_types=1);

namespace Pollen\Filebrowser\Exception;

use InvalidArgumentException;
use Throwable;

class FilebrowserActionNotice extends InvalidArgumentException implements FilebrowserException
{
    /**
     * @var string error|success|info|warning
     */
    protected $type = 'error';

    /**
     * @param string $type
     * @param string|null $actionName
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(
        string $type = 'error',
        string $message = '',
        ?string $actionName = null,
        int $code = 0,
        Throwable $previous = null
    ) {
        $this->type = $type;

        if (empty($message)) {
            if ($actionName !== null) {
                $message = sprintf('The action [%s] throws a [%s] notice.', $actionName, $type);
            } else {
                $message = sprintf('The action throws a [%s] notice.', $type);
            }
        }

        parent::__construct($message, $code, $previous);
    }

    /**
     * @return string error|success|info|warning
     */
    public function getType(): string
    {
        return $this->type;
    }
}