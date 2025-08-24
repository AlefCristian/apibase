<?php

$finder = PhpCsFixer\Finder::create()
    ->in([__DIR__])   // pasta raiz do projeto
    ->name('*.php')   // arquivos PHP
    ->exclude('vendor'); // não mexe no vendor

return (new PhpCsFixer\Config())
    ->setRules([
        // regras básicas de estilo
        'braces' => [
            'position_after_functions_and_oop_constructs' => 'same',
            'position_after_control_structures' => 'same',
            'position_after_anonymous_constructs' => 'same',
        ],
        'indentation_type' => true,       // usa tabs ou espaços conforme configurado
        'single_quote' => true,           // força aspas simples
        'no_trailing_whitespace' => true, // remove espaços no final da linha
        'trim_array_spaces' => true,      // remove espaços extras em arrays
        'binary_operator_spaces' => true, // espaços consistentes em operadores
    ])
    ->setFinder($finder)
    ->setUsingCache(true);