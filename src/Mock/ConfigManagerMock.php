<?php

declare(strict_types=1);

namespace SpipRemix\Sdk\Mock;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use SpipRemix\Contracts\ConfigManagerInterface;

/**
 * Undocumented class.
 *
 * @author JamesRezo <james@rezo.net>
 */
class ConfigManagerMock implements ConfigManagerInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    public function __construct(
        /** @var array<string,mixed> $config */
        private array $config = []
    ) {
    }

    public function all(): array
    {
        return $this->config;
    }

    public function get(string $name, mixed $default = null): mixed
    {
        if (array_key_exists($name, $this->config)) {
            return $this->config[$name];
        }

        return $default;
    }

    public function set(string $name, mixed $value = null, bool $importable = false): void
    {
        $this->config[$name] = $value;
    }

    public function clear(): void
    {
        $this->config = [];
    }

    public function unset(string $name): void
    {
        unset($this->config[$name]);
    }
}
