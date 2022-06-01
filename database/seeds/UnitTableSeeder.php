<?php

use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitTableSeeder extends Seeder
{
    protected $units = [
        ['name' => "Viss",'type' => 'sale_unit'],
        ['name' => "Pack",'type' => 'store_unit']
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        foreach ($this->units as $row) {
            factory(Unit::class)->create([
                'name' => $row["name"],
                'type' => $row["type"],
            ]);
        }
        Schema::enableForeignKeyConstraints();
    }
}
