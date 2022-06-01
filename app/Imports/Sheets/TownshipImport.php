<?php

namespace App\Imports\Sheets;

use App\Models\District;
use App\Models\Region;
use App\Models\Township;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TownshipImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (request()->get('District') === 'District') {
            Township::create([
                'name' => $row['name'],
                'mm_name' => $row['mm_name'],
                'region_id' => Region::where('name', $row['region_name'])->first()->id,
                'district_id' => District::where('name', $row['district_name'])->first()->id,
              ]);
        }
    }
}
