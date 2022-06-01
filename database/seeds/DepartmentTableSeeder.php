<?php

use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DepartmentTableSeeder extends Seeder
{
    protected $data = [
        ['name' => 'Admin' ],
        ['name' => 'Finance' ],
        ['name' => 'Operation' ],
        ['name' => 'Customer Service' ],
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
            factory(Department::class)->create([
                'name' => $row["name"],
            ]);
        }
        Schema::enableForeignKeyConstraints();
    }
}
