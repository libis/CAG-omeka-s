<?php
return [
    'block_layouts' => [
        'invokables' => [
            'textBlock' => TextBlock\Site\BlockLayout\TextBlock::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            dirname(__DIR__) . '/view',
        ],
    ]
];
