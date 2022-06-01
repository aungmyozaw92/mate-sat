<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'permission-list',
            'permission-create',
            'permission-edit',
            'permission-delete',
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
           
            'department-list',
            'department-create',
            'department-edit',
            'department-delete',
            'bank-list',
            'bank-create',
            'bank-edit',
            'bank-delete',
            
            'bank_information-list',
            'bank_information-create',
            'bank_information-edit',
            'bank_information-delete',
            
            'city-list',
            'city-create',
            'city-edit',
            'city-delete',
            'zone-list',
            'zone-create',
            'zone-edit',
            'zone-delete',
            
            'customer-list',
            'customer-create',
            'customer-edit',
            'customer-delete',
            
            'category-list',
            'category-create',
            'category-edit',
            'category-delete',
            'category-activate',
            
            'product-list',
            'product-create',
            'product-edit',
            'product-delete',

            'order-list',
            'order-create',
            'order-edit',
            'order-delete',

            'order_item-list',
            'order_item-create',
            'order_item-edit',
            'order_item-delete',

            'sale-list',
            'sale-create',
            'sale-edit',
            'sale-delete',

            'sale_payment-list',
            'sale_payment-create',
            'sale_payment-edit',
            'sale_payment-delete',

            'bottle_return-list',
            'bottle_return-create',
            'bottle_return-edit',
            'bottle_return-delete',
            
         ];
    
         foreach ($permissions as $permission) {
              Permission::create(['name' => $permission]);
         }

     //     foreach ($permissions as $permission) {
     //          Permission::create(['name' => $permission,'guard_name' => 'api']);
     //     }
    }
}
