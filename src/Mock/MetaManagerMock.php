<?php

declare(strict_types=1);

namespace SpipRemix\Component\Sdk\Mock;

use SpipRemix\Contracts\MetaManagerInterface;
use SpipRemix\Polyfill\Meta\MetaManagerTrait;

/**
 * Faux MetaManager.
 *
 * @author JamesRezo <james@rezo.net>
 */
class MetaManagerMock implements MetaManagerInterface
{
    use MetaManagerTrait;

    public function boot(): void {}
}
