<?php

// Fixers ruleset
$fixers = [
    // General Standards
    '@Symfony' => true,
    '@PSR2' => true,

    // Generic
    'array_syntax' => [ 'syntax' => 'short' ],
    'combine_consecutive_unsets' => true,
    'linebreak_after_opening_tag' => true,
    'list_syntax' => [ 'syntax' => 'long' ],
    'no_extra_consecutive_blank_lines' => [ 'break', 'continue', 'extra', 'return', 'throw', 'use', 'parenthesis_brace_block', 'curly_brace_block' ],
    'no_short_echo_tag' => true,
    'no_unreachable_default_argument_value' => true,
    'no_unused_imports' => true,
    'no_useless_else' => true,
    'no_useless_return' => true,
    'ordered_class_elements' => false,
    'ordered_imports' => [ 'sortAlgorithm' => 'length' ],
    'protected_to_private' => false,
    'semicolon_after_instruction' => true,
    'short_scalar_cast' => true,
    'ternary_to_null_coalescing' => true,
    'trailing_comma_in_multiline_array' => true,

    // Docblocks & Comments
    'phpdoc_add_missing_param_annotation' => true,
    'phpdoc_align' => true,
    'phpdoc_indent' => true,
    'phpdoc_inline_tag' => true,
    'phpdoc_no_empty_return' => false,
    'phpdoc_no_package' => false,
    'phpdoc_order' => true,
    'phpdoc_scalar' => true,
    'phpdoc_separation' => true,
    'phpdoc_trim' => true,
    'phpdoc_types' => true,
    'phpdoc_var_without_name' => true,

    'hash_to_slash_comment' => false,

    // Spacing and alignment
    'not_operator_with_successor_space' => true,
    'no_spaces_around_offset' => [
        'positions' => [ 'outside' ],
    ],

    // PHPUnit
    'php_unit_strict' => true,
    'php_unit_test_class_requires_covers' => false,
    'general_phpdoc_annotation_remove' => [ 'expectedException', 'expectedExceptionMessage', 'expectedExceptionMessageRegExp' ],
];

// Directories that should be excluded from being scanned
$excludeDirs = [];

// Files that should be excluded from being scanned
$excludeFiles = [];

// Create a new Symfony Finder instance
$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->exclude($excludeDirs)
    ->filter(function (\SplFileInfo $file) use ($excludeFiles) {
        return ! in_array($file->getRelativePathName(), $excludeFiles);
    })
;

// Create and return a PHP CS Fixer instance
return PhpCsFixer\Config::create()
    ->setRules($fixers)->setFinder($finder)
    ->setUsingCache(false)->setRiskyAllowed(true)
;
