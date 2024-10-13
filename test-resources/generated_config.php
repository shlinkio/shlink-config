<?php

declare(strict_types=1);

return [

    'foo' => 'not_loaded',
    'foo2' => [],
    'BAR' => true,
    'BAZ' => false,
    'NUMBER' => 3,
    'NULL' => null,
    'invalid' => [
        'nested_invalid' => 'string',
    ],
    'OVERWRITTEN_ENV' => 'overwrite_value',
    'ENV_ARRAY' => ['foo', 'bar', 'baz'],

];
