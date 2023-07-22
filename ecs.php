<?php

declare(strict_types = 1);

use Symplify\EasyCodingStandard\Config\ECSConfig;
use Hypefactors\CodeStandards\Config\HypefactorsEcsConfig;

return static function (ECSConfig $ecsConfig): void {
    $ecsConfig->paths([
        __DIR__ . '/src',
        __DIR__ . '/database',
        __DIR__ . '/tests',
    ]);

    HypefactorsEcsConfig::setup($ecsConfig);
};
