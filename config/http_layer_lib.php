<?php

declare(strict_types=1);

return [
    'serializer' => [
        'context'    => [
            'serialize_nulls' => false,
        ],
        'definition' => [
            'path' => dirname(__DIR__, 1) . '/resources/serializer_definitions',
        ],
        'cache_dir'  => [
            'path' => storage_path('framework/cache/serializer'),
        ],
    ],
];
