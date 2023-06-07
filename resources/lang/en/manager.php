<?php

return [

    'validation' => [
        'identification_number' => [
            'required' => 'The identification number field is required.',
            'integer' => 'The identification number must be an integer.',
            'unique' => 'The identification number has already been taken.',
        ],
        'tax_number' => [
            'required' => 'The tax number field is required.',
            'string' => 'The tax number must be a string.',
            'max' => 'The tax number must not be greater than :max.',
            'unique' => 'The tax number has already been taken.',
        ],
        'commercial_register' => [
            'required' => 'The commercial register number field is required.',
            'integer' => 'The commercial register number must be an integer.',
            'max' => 'The commercial register number must not be greater than :max.',
            'unique' => 'The commercial register number has already been taken.',
        ],
        'branch_id' => [
            'exists' => 'The selected branch is invalid.',
        ],
    ],

];
