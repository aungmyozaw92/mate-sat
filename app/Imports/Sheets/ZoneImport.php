<?php

namespace App\Imports\Sheets;

use App\Models\City;
use App\Models\Zone;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ZoneImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (request()->get('Zone') === 'Zone') {
            Zone::create([
                'name' => $row['name'],
                'mm_name' => $row['mm_name'],
                'city_id' => City::where('name', $row['city_name'])->first()->id,
            ]);
        }
    }
}
