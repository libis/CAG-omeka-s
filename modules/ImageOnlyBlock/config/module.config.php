<?php
return [
    'block_layouts' => [
        'invokables' => [
            'ImageOnlyBlock' => ImageOnlyBlock\Site\BlockLayout\ImageOnlyBlock::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            dirname(__DIR__) . '/view',
        ],
    ]
];
