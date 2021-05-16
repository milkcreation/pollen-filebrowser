<?php

declare(strict_types=1);

namespace Pollen\Filebrowser;

use Pollen\Support\Exception\ProxyInvalidArgumentException;
use Pollen\Support\ProxyResolver;
use RuntimeException;
use Throwable;

/**
 * @see \Pollen\Filebrowser\FilebrowserProxyInterface
 */
trait FilebrowserProxy
{
    /**
     * Instance du gestionnaire de navigateurs de fichiers.
     * @var FilebrowserManagerInterface|null
     */
    private $filebrowserManager;

    /**
     * Instance du gestionnaire de navigateurs de fichiers.
     *
     * @param string|null $name
     *
     * @return FilebrowserManagerInterface|FilebrowserInterface
     */
    public function filebrowser(?string $name = null)
    {
        if ($this->filebrowserManager === null) {
            try {
                $this->filebrowserManager = FilebrowserManager::getInstance();
            } catch (RuntimeException $e) {
                $this->filebrowserManager = ProxyResolver::getInstance(
                    FilebrowserManagerInterface::class,
                    FilebrowserManager::class,
                    method_exists($this, 'getContainer') ? $this->getContainer() : null
                );
            }
        }

        if ($name === null) {
            return $this->filebrowserManager;
        }

        try {
            return $this->filebrowserManager->get($name);
        } catch(Throwable $e) {
            throw new ProxyInvalidArgumentException(sprintf('Filebrowser [%s] is unavailable', $name), 0, $e);
        }
    }

    /**
     * Définition du gestionnaire de navigateurs de fichiers.
     *
     * @param FilebrowserManagerInterface $filebrowserManager
     *
     * @return void
     */
    public function setFilebrowserManager(FilebrowserManagerInterface $filebrowserManager): void
    {
        $this->filebrowserManager = $filebrowserManager;
    }
}