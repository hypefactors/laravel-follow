<?php

declare(strict_types = 1);

use Rector\Config\RectorConfig;
use Hypefactors\CodeStandards\Config\HypefactorsRectorConfig;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->disableParallel();

    HypefactorsRectorConfig::setup($rectorConfig);

    $rectorConfig->paths([
        __DIR__ . '/src',
        __DIR__ . '/database',
        __DIR__ . '/tests',
    ]);

    // Define extra rule sets to be applied
    $rectorConfig->sets([
        // SetList::DEAD_CODE,
    ]);

    // Register extra a single rules
    // $rectorConfig->rule(ClassOnObjectRector::class);
};
