<?php
return [
    'block_layouts' => [
        'invokables' => [
            'CagBrowseBlock' => CagBrowseBlock\Site\BlockLayout\CagBrowseBlock::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            dirname(__DIR__) . '/view',
        ],
    ]
];
