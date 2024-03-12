<?php

declare(strict_types=1);

namespace SpipRemix\Component\Sdk\Mock;

use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;
use SpipRemix\Contracts\ConfigManagerInterface;
use SpipRemix\Contracts\MetaManagerInterface;

/**
 * Undocumented class.
 *
 * @author JamesRezo <james@rezo.net>
 */
class ConfigManagerMock implements ConfigManagerInterface
{
    use LoggerAwareTrait;

    public function __construct(
       private MetaManagerInterface $config,
    ) {
    }

    public function getLogger(): ?LoggerInterface
    {
        return $this->logger;
    }

    public function all(): array
    {
        return $this->config->all();
    }

    public function get(string $name, mixed $default = null): mixed
    {
        return $this->config->get($name, $default);
    }

    public function set(string $name, mixed $value = null, bool $importable = false): void
    {
        $this->config->set($name, $value, $importable);
    }

    public function clear(): void
    {
        $this->config->clear();
    }

    public function unset(string $name): void
    {
        $this->config->unset($name);
    }
}
