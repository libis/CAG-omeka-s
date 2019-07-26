<?php
return [
    'logger' => [
        'log' => true,
        'priority' => \Zend\Log\Logger::NOTICE,
    ],
    'http_client' => [
        'sslcapath' => null,
        'sslcafile' => null,
    ],
    'cli' => [
        'phpcli_path' => '',
    ],
    'thumbnails' => [
        'types' => [
            'large' => ['constraint' => 1000],
            'medium' => ['constraint' => 400],
            'square' => ['constraint' => 400],
        ],
        'thumbnailer_options' => [
            'imagemagick_dir' => null,
        ],
    ],
    'translator' => [
        'locale' => 'en_US',
    ],
    'service_manager' => [
        'aliases' => [
            'Omeka\File\Store' => 'Omeka\File\Store\Local',
            'Omeka\File\Thumbnailer' => 'Omeka\File\Thumbnailer\ImageMagick',
        ],
    ],
];
