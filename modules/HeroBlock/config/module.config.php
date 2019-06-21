<?php
return [
    'block_layouts' => [
        'invokables' => [
            'heroBlock' => HeroBlock\Site\BlockLayout\HeroBlock::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            dirname(__DIR__) . '/view',
        ],
    ]
];
