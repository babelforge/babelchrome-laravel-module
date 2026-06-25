<?php

declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

return (new Config())
    ->setRiskyAllowed(false)
    ->setRules([
        '@auto' => true,
        '@Symfony' => true,
    ])
    ->setFinder(
        (new Finder())
            ->in(__DIR__.'/public')
            ->in(__DIR__.'/src')
            ->in(__DIR__.'/tests')
            ->exclude([__DIR__.'/vendor', __DIR__.'/var'])
    )
;
