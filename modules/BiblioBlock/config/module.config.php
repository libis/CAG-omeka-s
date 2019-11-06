<?php
return [
    'block_layouts' => [
        'invokables' => [
            'BiblioBlock' => BiblioBlock\Site\BlockLayout\BiblioBlock::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            dirname(__DIR__) . '/view',
        ],
    ]
];
