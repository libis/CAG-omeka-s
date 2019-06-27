<?php
return [
    'block_layouts' => [
        'invokables' => [
            'textImageBlock' => TextImageBlock\Site\BlockLayout\TextImageBlock::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            dirname(__DIR__) . '/view',
        ],
    ]
];
