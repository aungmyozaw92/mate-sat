<?php

namespace App\Imports\Sheets;

use App\Models\District;
use App\Models\Region;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DistrictImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (request()->get('District') === 'District') {
            District::create([
                'name' => $row['name'],
                'mm_name' => $row['mm_name'],
                'region_id' => Region::where('name', $row['region_name'])->first()->id,
              ]);
        }
    }
}
