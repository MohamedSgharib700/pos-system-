<?php

return [
    'model_id'=>[
        'required' => 'The model_id field is required.',
        'int' => 'The model_id must be an integer.',
    ],
    'model_type'=>[
        'required' => 'The model_type field is required.',
        'string' => 'The model_type must be a string.',
    ],
    'banck' => [
        'required' => 'The bank field is required.',
        'int' => 'The bank must be an integer.',
        'exists' => 'The selected bank is invalid.'
    ],
    'iban' => [
        'required' => 'The iban field is required.',
        'string' => 'The iban must be a string.',
        'unique' => 'The iban has already been taken.'
    ]
];
