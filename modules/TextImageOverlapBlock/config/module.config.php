<?php
return [
    'block_layouts' => [
        'invokables' => [
            'textImageOverlapBlock' => TextImageOverlapBlock\Site\BlockLayout\TextImageOverlapBlock::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            dirname(__DIR__) . '/view',
        ],
    ]
];
