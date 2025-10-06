<?php

declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->in(__DIR__.'/src')
;

return (new Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@Symfony' => true,
        'array_syntax' => ['syntax' => 'short'],
        'strict_param' => true,
        'no_unused_imports' => true,
        'single_quote' => true,
        'phpdoc_align' => ['align' => 'left'],
        'yoda_style' => false,
    ])
    ->setFinder($finder)
;
