<?php

// add new permission like this ('addPermissions' => ['force_delete' => 'حذف نهائى'])
// except permissions from default like this ('exceptPermissions' => ['-edit', '-delete'])
return [
    'admin' => [
        [
            'name' => 'role',
            'slug' => 'نظام الصلاحيات',
        ],
        [
            'name' => 'admin',
            'slug' => 'المديرين',
            'addPermissions' => ['unlock' => 'فك الحظر']
        ],
        [
            'name' => 'user',
            'slug' => 'المستخدمين',
            'addPermissions' => ['export-excel' => 'تصدير للإكسل', 'import-excel' => 'استيراد من الإكسل']
        ],
        [
            'name' => 'page',
            'slug' => 'الصفحات الثابتة',
        ],
        [
            'name' => 'company',
            'slug' => 'الشركات',
        ],
        [
            'name' => 'areas',
            'slug' => 'المناطق',
            'addPermissions' => ['export-excel' => 'تصدير للإكسل', 'import-excel' => 'استيراد من الإكسل']
        ],
        [
            'name' => 'cities',
            'slug' => 'المحافظات',
            'addPermissions' => ['export-excel' => 'تصدير للإكسل', 'import-excel' => 'استيراد من الإكسل']
        ],
        [
            'name' => 'branch',
            'slug' => 'الفروع',
        ],
        [
            'name' => 'commission',
            'slug' => 'العمولات',
            'addPermissions' => ['delete-many' => 'حذف متعدد']
        ],
        [
            'name' => 'manager',
            'slug' => 'المديرين',
            'addPermissions' => ['activate' => 'تفعيل', 'unlock' => 'فك الحظر']
        ],
        [
            'name' => 'services-providers',
            'slug' => 'مزودين الخدمة',
        ],
        [
            'name' => 'banks',
            'slug' => 'البنوك',
        ],
        [
            'name' => 'banks-accounts',
            'slug' => 'حسابات البنوك',
        ],
    ],
    'manager' => [
        [
            'name' => 'role',
            'slug' => 'نظام الصلاحيات',
        ],
        [
            'name' => 'manager',
            'slug' => 'المديرين',
            'addPermissions' => ['activate' => 'تفعيل', 'unlock' => 'فك الحظر']
        ],
        [
            'name' => 'pos_user',
            'slug' => 'مستخدمي نقاط البيع',
            'addPermissions' => ['unlock' => 'فك الحظر']
        ],
        [
            'name' => 'company',
            'slug' => 'الشركات',
            'exceptPermissions' => ['-list', '-delete']
        ],
        [
            'name' => 'branch',
            'slug' => 'الفروع',
        ]
    ],
];
