<?php
return [
    'block_layouts' => [
        'invokables' => [
            'contactBlock' => TeamBlock\Site\BlockLayout\TeamBlock::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            dirname(__DIR__) . '/view',
        ],
    ]
];
