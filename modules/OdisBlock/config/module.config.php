<?php
return [
    'block_layouts' => [
        'invokables' => [
            'OdisBlock' => OdisBlock\Site\BlockLayout\OdisBlock::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            dirname(__DIR__) . '/view',
        ],
    ]
];
