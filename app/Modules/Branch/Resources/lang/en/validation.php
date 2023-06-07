<?php

return [
    'name' => [
        'required' => 'The name field is required.',
    ],
    'company_id' => [
        'required' => 'The company field is required.',
        'exists' => 'The selected company is invalid.',
    ],
    'manager_id' => [
        'required' => 'The manager field is required.',
        'exists' => 'The selected manager is invalid.',
    ],
    'city_id' => [
        'required' => 'The city field is required.',
        'exists' => 'The selected city is invalid.',
    ],
];
