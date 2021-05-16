<?php

declare(strict_types=1);

namespace Pollen\Filebrowser\Factory;

use ArrayIterator;

class Breadcrumb implements BreadcrumbInterface
{
    use FilebrowserAwareTrait;

    /**
     * @var string[]
     */
    protected $parts = [];

    /**
     * @inheritDoc
     */
    public function all(): array
    {
        return $this->parts;
    }

    /**
     * @inheritDoc
     */
    public function clear(): void
    {
        $this->parts = [];
    }

    /**
     * @inheritDoc
     */
    public function fetch(string $path): void
    {
        $this->clear();

        $this->parts['/'] = $this->getHomeContent();

        $parts = explode('/', $path);
        $url = '';

        foreach ($parts as $part) {
            if ($part !== '/' && $part !== '') {
                $url .= '/' . $part;
                $this->parts[$url] = $part;
            }
        }
    }

    /**
     * @inheritDoc
     */
    public function getHomeContent(): string
    {
        return $this->filebrowser()->icons->render('home');
    }

    /**
     * @inheritDoc
     */
    public function count(): int
    {
        return count($this->parts);
    }

    /**
     * @inheritDoc
     */
    public function get(string $url): ?string
    {
        return $this->parts[$url] ?? null;
    }

    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        return new ArrayIterator($this->parts);
    }

    /**
     * @inheritDoc
     */
    public function offsetExists($offset): bool
    {
        return array_key_exists($offset, $this->parts);
    }

    /**
     * @inheritDoc
     */
    public function offsetGet($offset): ?string
    {
        return $this->parts[$offset] ?? null;
    }

    /**
     * @inheritDoc
     */
    public function offsetSet($offset, $value): void
    {
        if ($offset === null) {
            $this->parts[] = $value;
        } else {
            $this->parts[$offset] = $value;
        }
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset($offset): void
    {
        unset($this->parts[$offset]);
    }
}