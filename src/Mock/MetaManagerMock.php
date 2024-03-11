<?php

declare(strict_types=1);

namespace SpipRemix\Sdk\Mock;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use SpipRemix\Contracts\MetaManagerInterface;
use SpipRemix\Contracts\MetaManagerTrait;

/**
 * Undocumented class.
 *
 * @api
 *
 * @author JamesRezo <james@rezo.net>
 */
class MetaManagerMock implements MetaManagerInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;
    use MetaManagerTrait;
}
