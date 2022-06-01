<?php

namespace App\Imports\Sheets;

use App\Models\Region;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RegionImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (request()->get('Region') === 'Region') {
            Region::create([
                'name' => $row['name'],
                'mm_name' => $row['mm_name'],
            ]);
        }
    }
}
