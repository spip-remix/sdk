<?php

declare(strict_types=1);

namespace SpipRemix\Sdk\Mock;

use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerAwareInterface;
use SpipRemix\Contracts\MetaInterface;

/**
 * Undocumented class.
 *
 * @api
 *
 * @author JamesRezo <james@rezo.net>
 */
class Config implements ConfigInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    public function __construct(
        /** @var array<string,mixed> $metas */
        private array $metas = []
    ) {
    }

    public function read(string $meta, mixed $default = null): mixed
    {
        if (array_key_exists($meta, $this->metas)) {
            return $this->metas[$meta];
        }

        return $default;
    }

    public function write(string $meta, mixed $value = null): void
    {
        $this->metas[$meta] = $value;
    }

    public function truncate(): void
    {
        $this->metas = [];
    }

    public function delete(string $meta): void
    {
        unset($this->metas[$meta]);
    }
}
