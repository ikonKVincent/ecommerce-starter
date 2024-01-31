<?php

return [
    'disable_variants' => false,
    'require_brand' => false,

    /* Product identifiers */
    'reference' => [
        'required' => true,
        'unique' => true,
    ],
    'sku_code' => [
        'required' => false,
        'unique' => true,
    ],
    'gtin_code' => [
        'required' => false,
        'unique' => false,
    ],
    'mpn_code' => [
        'required' => false,
        'unique' => false,
    ],
    'ean_code' => [
        'required' => false,
        'unique' => false,
    ],
];
