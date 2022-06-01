<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Schema;

class RoleTableSeeder extends Seeder
{
    protected $data = [
        'Super Admin' ,
        'Admin' ,
        'Finance Manager' ,
        'Finance' ,
        'Sale Manager' ,
        'Sale' ,
        'Operation Manager' ,
        'Operation' ,
        'Customer Service Manager' ,
        'Customer Service' ,
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
            factory(Role::class)->create([
                'name' => $row
            ]);
        }
        Schema::enableForeignKeyConstraints();
    }
}
    
    
    
    
    