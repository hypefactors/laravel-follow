<?php

// Fixers ruleset
$fixers = [
    // General Standards
    '@Symfony' => true,
    '@PSR1' => true,
    '@PSR2' => true,

    // Generic
    'array_syntax' => [ 'syntax' => 'short' ],
    'combine_consecutive_issets' => true,
    'combine_consecutive_unsets' => true,
    'linebreak_after_opening_tag' => true,
    'list_syntax' => [ 'syntax' => 'long' ],
    'no_extra_consecutive_blank_lines' => [ 'break', 'continue', 'extra', 'return', 'throw', 'use', 'parenthesis_brace_block', 'curly_brace_block' ],
    'no_short_echo_tag' => true,
    'no_trailing_comma_in_singleline_array' => true,
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
    'binary_operator_spaces' => [
        'align_double_arrow' => true,
        'align_equals' => true,
    ],
    'pre_increment' => false,
    'yoda_style' => false,

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
    'no_empty_comment' => false,
    'no_empty_phpdoc' => false,
    'no_empty_statement' => false,

    // Spacing and alignment
    'method_argument_space' => true,
    'not_operator_with_successor_space' => true,
    'no_spaces_around_offset' => [
        'positions' => [ 'outside' ],
    ],
    'trim_array_spaces' => true,

    // PHPUnit
    'php_unit_strict' => true,
    'php_unit_test_class_requires_covers' => false,
    'general_phpdoc_annotation_remove' => [ 'expectedException', 'expectedExceptionMessage', 'expectedExceptionMessageRegExp' ],
];

// Directories to not scan
$excludeDirs = [];

// Files to not scan
$excludeFiles = [];

// Create a new Symfony Finder instance
$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->exclude($excludeDirs)
    ->ignoreDotFiles(true)->ignoreVCS(true)
    ->filter(function (\SplFileInfo $file) use ($excludeFiles) {
        return ! in_array($file->getRelativePathName(), $excludeFiles);
    })
;

// Create and return a PHP CS Fixer instance
return PhpCsFixer\Config::create()
    ->setRules($fixers)->setFinder($finder)
    ->setUsingCache(false)->setRiskyAllowed(true)
;
