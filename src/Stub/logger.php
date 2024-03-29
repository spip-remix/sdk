<?php

use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;

function spip_logger(string $filename = 'spip'): LoggerInterface
{
    return new class () implements LoggerInterface {
        use LoggerTrait;

        public function log($level, string|\Stringable $message, array $context = []): void {}
    };
}
