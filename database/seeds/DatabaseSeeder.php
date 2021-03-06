<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleTableSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(DepartmentTableSeeder::class);
        $this->call(UserTableSeeder::class);
        // $this->call(UnitTableSeeder::class);
        $this->call(BankTableSeeder::class);
        $this->call(CityTableSeeder::class);
        $this->call(ZoneTableSeeder::class);
        $this->call(CustomerTableSeeder::class);
        $this->call(CategoryTableSeeder::class);
        $this->call(ProductTableSeeder::class);
        $this->call(LogStatusTableSeeder::class);
        $this->call(PaymentMethodTableSeeder::class);
    }
}
