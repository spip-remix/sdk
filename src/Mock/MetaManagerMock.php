<?php

declare(strict_types=1);

namespace SpipRemix\Component\Sdk\Mock;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use SpipRemix\Contracts\MetaManagerInterface;
use SpipRemix\Contracts\MetaManagerTrait;

/**
 * Faux MetaManager.
 *
 * @author JamesRezo <james@rezo.net>
 */
class MetaManagerMock implements MetaManagerInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;
    use MetaManagerTrait;
}
