<?php

return [
    'slug' => [
        'required' => 'The slug field is required.',
        'string' => 'The slug must be a string.',
        'max' => 'The slug must not be greater than :max.',
        'unique' => 'The slug has already been taken.',
    ],
    'permission' => [
        'required' => 'The permission field is required.',
        'array' => 'The permission must not have more than :max items.',
        'unique' => 'The permission has already been taken.',
        '*' => [
            'string' => 'The permission items must be a string.',
            'exists' => 'The selected permission items is invalid.',
        ],
    ],
];
