<?php
return [
    'block_layouts' => [
        'invokables' => [
            'introTextBlock' => IntroTextBlock\Site\BlockLayout\IntroTextBlock::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            dirname(__DIR__) . '/view',
        ],
    ]
];
