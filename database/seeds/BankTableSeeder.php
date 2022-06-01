<?php

use App\Models\Bank;
use Illuminate\Database\Seeder;

class BankTableSeeder extends Seeder
{
   protected $data = [
        "AYA",
        "KBZ",
        "CB",
        "UAB",
        "WAVE",
        
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         Schema::disableForeignKeyConstraints();
        foreach ($this->data as $row) {
            Bank::create([
                'name' => $row
            ]);
        }
        Schema::enableForeignKeyConstraints();
    }
}
