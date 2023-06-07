<?php

return [
    'validation' => [
        'company_id' => [
            'required' => 'The company field is required.',
            'integer' => 'The company must be an integer.',
            'exists' => 'The selected company is invalid.',
        ],
        'branch_id' => [
            'required' => 'The branch field is required.',
            'integer' => 'The branch must be an integer.',
            'exists' => 'The selected branch is invalid.',
        ],
        'identification_number' => [
            'required' => 'The identification number field is required.',
            'integer' => 'The identification number must be an integer.',
        ],
        'serial_number' => [
            'required' => 'The serial number field is required.',
            'integer' => 'The serial number must be an integer.',
        ],
        'serial_code' => [
            'required' => 'The serial code field is required.',
            'integer' => 'The selected :attribute is invalid.',
        ],
    ],
];

