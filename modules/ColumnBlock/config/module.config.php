<?php
return [
    'block_layouts' => [
        'invokables' => [
            'columnBlock' => ColumnBlock\Site\BlockLayout\ColumnBlock::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            dirname(__DIR__) . '/view',
        ],
    ]
];
