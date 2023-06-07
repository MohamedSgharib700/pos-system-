<?php

return [
    'name' => [
        'required' => 'The company name field is required.',
    ],
    'finance_manager' => [
        'required' => 'The finance manager field is required.',
        'exists' => 'The selected finance manager is invalid or alread belongs to a company.',
    ],
    'owner_id' => [
        'required' => 'The owner field is required.',
        'exists' => 'The selected owner is invalid or alread belongs to a company.',
    ],
    'tax_number' => [
        'required' => 'The tax number field is required.',
        'string' => 'The tax number must be a string.',
        'max' => 'The tax number must not be greater than :max.',
        'unique' => 'The tax number has already been taken.',
    ],
    'commercial_register' => [
        'required' => 'The commercial register field is required.',
        'string' => 'The commercial register must be a string.',
        'max' => 'The commercial register must not be greater than :max.',
        'unique' => 'The commercial register has already been taken.',
    ],
    'type' => [
        'required' => 'The type field is required.',
        'string' => 'The type must be a string.',
        'in' => 'The selected type is invalid.',
    ],
];
