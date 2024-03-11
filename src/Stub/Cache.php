<?php

declare(strict_types=1);

namespace SpipRemix\Sdk\Stub;

use Psr\SimpleCache\CacheInterface;

class Cache implements CacheInterface
{
    public function get(string $key, mixed $default = null): mixed
    {
        return $default;
    }

    public function set(string $key, mixed $value, \DateInterval|int|null $ttl = null): bool
    {
        return true;
    }

    public function delete(string $key): bool
    {
        return true;
    }

    public function clear(): bool
    {
        return true;
    }

    public function getMultiple(\Traversable|array $keys, mixed $default = null): \Traversable|array
    {
        return $default;
    }

    public function setMultiple(\Traversable|array $values, \DateInterval|int|null $ttl = null): bool
    {
        return true;
    }

    public function deleteMultiple(\Traversable|array $keys): bool
    {
        return true;
    }

    public function has(string $key): bool
    {
        return true;
    }
}
