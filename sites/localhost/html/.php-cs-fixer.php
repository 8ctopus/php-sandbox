<?php

$risky = isset($GLOBALS['argv']) && in_array('--allow-risky=yes', $GLOBALS['argv'], true);

$finder = PhpCsFixer\Finder::create()
    ->exclude('vendor/')
    ->in('.');

$fixer = (new PhpCsFixer\Config('Sandbox', 'Sandbox style guide'))
    ->setRules([
        '@PhpCsFixer' => true,
        'blank_line_before_statement' => [
            'statements' => [
                'case',
                'default',
            ],
        ],
        'concat_space' => [
            'spacing' => 'one',
        ],
        'echo_tag_syntax' => [
            'format' => 'short',
        ],
        'global_namespace_import' => [
            'import_classes' => true,
            'import_constants' => false,
            'import_functions' => false,
        ],
        'multiline_whitespace_before_semicolons' => false,
        'no_empty_comment' => false,
        'no_superfluous_phpdoc_tags' => false,
        'no_unused_imports' => false,
        'no_useless_else' => false,
        'phpdoc_add_missing_param_annotation' => true,
        'phpdoc_no_empty_return' => false,
        'phpdoc_summary' => false,
        'phpdoc_trim' => true,
        'phpdoc_trim_consecutive_blank_line_separation' => true,
        'php_unit_method_casing' => false,
        'psr_autoloading' => false,
        'return_type_declaration' => [
            'space_before' => 'one',
        ],
        'single_line_comment_spacing' => false,
        'yoda_style' => false,
    ])
    ->setFinder($finder);

if ($risky) {
    echo 'Risky rules enabled' . PHP_EOL;

    $fixer
        ->setRules([
            '@PhpCsFixer:risky' => true,
            'native_function_invocation' => false,
            'phpdoc_to_param_type' => true,
            'phpdoc_to_property_type' => true,
            'phpdoc_to_return_type' => true,
            'psr_autoloading' => false,
            'void_return' => true,
        ]);
}

return $fixer;
