<?php

return [
    'value' => [
        'required' => '.حقل قيمة العمولة مطلوب',
        'integer' => '.يحب ان يكون حقل قيمة العمولة رقم',
        'min' => '.يجب أن لا يقل طول نّص حقل قيمة العمولة عن :min حرف'
    ],
    'company_id' => [
        'required' => '.حقل قيمة الشركة مطلوب',
        'integer' => '.يحب ان يكون حقل قيمة الشركة رقم',
        'exists' => '.القيمة المحددة لحقل الشركة غير موجودة'
    ],
];