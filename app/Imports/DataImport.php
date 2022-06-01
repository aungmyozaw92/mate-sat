<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsUnknownSheets;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class DataImport implements WithMultipleSheets, SkipsUnknownSheets
{
    public function sheets(): array
    {
        return [
            'Region' => new Sheets\RegionImport(),
            'District' => new Sheets\DistrictImport(),
            'Township' => new Sheets\TownshipImport(),
            'City' => new Sheets\CityImport(),
            'Ward' => new Sheets\WardImport(),
            'Zone' => new Sheets\ZoneImport(),
        ];
    }

    public function onUnknownSheet($sheetName)
    {
        // E.g. you can log that a sheet was not found.
        info("Sheet {$sheetName} was skipped");
    }
}
