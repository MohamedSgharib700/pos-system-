<?php

return [
    'value' => [
        'required' => 'The commision value field is required.',
        'integer' => 'The commercial register must be a number.',
        'min' => 'The tax number must not be less than :min.'
    ],
    'company_id' => [
        'required' => 'The company name field is required.',
        'integer' => 'The commercial register must be a number.',
        'exists' => 'The selected company is invalid.'
    ],
];
