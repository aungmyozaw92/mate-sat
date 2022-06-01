<?php

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class CategoryTableSeeder extends Seeder
{
    protected $data = [
        ['name' => 'Oil'],
        ['name' => 'Food'],
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
            factory(Category::class)->create([
                'name' => $row["name"]
            ]);
        }
        Schema::enableForeignKeyConstraints();
    }
}
