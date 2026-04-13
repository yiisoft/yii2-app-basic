<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\ArrayNotation\ArraySyntaxFixer;
use PhpCsFixer\Fixer\ClassNotation\ClassDefinitionFixer;
use PhpCsFixer\Fixer\Import\NoUnusedImportsFixer;
use PhpCsFixer\Fixer\Operator\ConcatSpaceFixer;
use PhpCsFixer\Fixer\StringNotation\SingleQuoteFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;

return ECSConfig::configure()
    ->withConfiguredRule(ArraySyntaxFixer::class, ['syntax' => 'short'])
    ->withConfiguredRule(ClassDefinitionFixer::class, ['space_before_parenthesis' => true])
    ->withConfiguredRule(ConcatSpaceFixer::class, ['spacing' => 'one'])
    ->withConfiguredRule(SingleQuoteFixer::class, ['strings_containing_single_quote_chars' => false])
    ->withFileExtensions(['php'])
    ->withPaths(
        [
            __DIR__ . '/src',
            __DIR__ . '/tests',
        ],
    )
    ->withPreparedSets(psr12: true)
    ->withRules([NoUnusedImportsFixer::class]);
