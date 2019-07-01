<?php
return [
    'block_layouts' => [
        'invokables' => [
            'introBlock' => IntroBlock\Site\BlockLayout\IntroBlock::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            dirname(__DIR__) . '/view',
        ],
    ]
];
