<?php

namespace App\Modules\Areas\Imports;

use App\Modules\Areas\Entities\Area;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class AreaImport implements ToCollection, WithValidation
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row => $value) {
            if ($row != 0) {
                Area::create([
                    'name' => ['en' => $value[0], 'ar' => $value[1]],
                ]);
            }
        }
    }

    public function rules(): array
    {
        return [
            '0' => ['required', 'unique:cities,name->en'],
            '1' => ['required', 'unique:cities,name->ar'],

        ];
    }

    public function customValidationAttributes()
    {
        return [
            '0' => 'name_en',
            '1' => 'name_ar',
        ];
    }

}
