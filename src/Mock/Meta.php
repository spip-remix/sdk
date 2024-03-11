<?php

declare(strict_types=1);

namespace SpipRemix\Sdk\Mock;

use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerAwareInterface;
use SpipRemix\Contracts\MetaInterface;
use SpipRemix\Contracts\MetaTrait;

/**
 * Undocumented class.
 *
 * @api
 *
 * @author JamesRezo <james@rezo.net>
 */
class Meta implements MetaInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;
    use MetaTrait;
}
