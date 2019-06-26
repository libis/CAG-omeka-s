<?php
return [
    'block_layouts' => [
        'invokables' => [
            'borderBlock' => BorderBlock\Site\BlockLayout\BorderBlock::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            dirname(__DIR__) . '/view',
        ],
    ]
];
