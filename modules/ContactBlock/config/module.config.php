<?php
return [
    'block_layouts' => [
        'invokables' => [
            'contactBlock' => ContactBlock\Site\BlockLayout\ContactBlock::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            dirname(__DIR__) . '/view',
        ],
    ]
];
