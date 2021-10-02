<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\ArrayNotation\ArraySyntaxFixer;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\EasyCodingStandard\ValueObject\Option;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ContainerConfigurator $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::PATHS, [
        __DIR__ . '/repositories',
        __DIR__ . '/middleware',
        __DIR__ . '/events',
        __DIR__ . '/lib',
        __DIR__ . '/app'
    ]);

    // $parameters->set(Option::SKIP, [
    //     // skip paths with legacy code
    //     __DIR__ . '/src/Resources/Traits/EmojiTrait.php'
    // ]);

    $services = $containerConfigurator->services();
    $services->set(ArraySyntaxFixer::class)
        ->call('configure', [[
            'syntax' => 'short',
        ]]);

    // [default: spaces]
    $parameters->set(Option::INDENTATION, 'spaces');

    // [default: PHP_EOL]; other options: "\n"
    $parameters->set(Option::LINE_ENDING, "\n");

    // run and fix, one by one
    $containerConfigurator->import(SetList::PSR_12);
    $containerConfigurator->import(SetList::CLEAN_CODE);
    $containerConfigurator->import(SetList::NAMESPACES);
    $containerConfigurator->import(SetList::ARRAY);
};
