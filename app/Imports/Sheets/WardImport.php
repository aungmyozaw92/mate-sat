<?php

namespace App\Imports\Sheets;

use App\Models\City;
use App\Models\Region;
use App\Models\District;
use App\Models\Township;
use App\Models\Ward;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class WardImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (request()->get('Ward') === 'Ward') {
            Ward::create([
                'name' => $row['name'],
                'mm_name' => $row['mm_name'],
                'region_id' => Region::where('name', $row['region_name'])->first()->id,
                'district_id' => District::where('name', $row['district_name'])->first()->id,
                'township_id' => Township::where('name', $row['township_name'])->first()->id,
                'city_id' => City::where('name', $row['city_name'])->first()->id,
              ]);
        }
    }
}
