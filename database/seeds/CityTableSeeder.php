<?php

use App\Models\City;
use App\Models\District;
use App\Models\Region;
use App\Models\Township;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class CityTableSeeder extends Seeder
{
    protected $cities = [
        ['name' => 'Yangon', 'mm_name' => 'ရန််'],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        // factory(City::class, 20)->create();
        foreach ($this->cities as $row) {
            factory(City::class)->create([
                'name' => $row["name"],
                'mm_name' => $row["mm_name"],
                // 'created_by' => $row["created_by"],
            ]);
        }

        Schema::enableForeignKeyConstraints();
    }
}