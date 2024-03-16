<?php

declare(strict_types=1);

namespace SpipRemix\Component\Sdk\Mock;

use SpipRemix\Contracts\MetaHandlerInterface;
use SpipRemix\Polyfill\Meta\MetaHandlerTrait;

/**
 * Faux MetaHandler.
 *
 * @author JamesRezo <james@rezo.net>
 */
class MetaHandlerMock implements MetaHandlerInterface
{
    use MetaHandlerTrait;

    public function boot(): void {}
}
