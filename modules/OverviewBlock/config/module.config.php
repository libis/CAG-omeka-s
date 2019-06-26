<?php
return [
    'block_layouts' => [
        'invokables' => [
            'overviewBlock' => OverviewBlock\Site\BlockLayout\OverviewBlock::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            dirname(__DIR__) . '/view',
        ],
    ]
];
