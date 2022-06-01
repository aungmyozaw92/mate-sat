<?php

use App\Models\LogStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class LogStatusTableSeeder extends Seeder
{
     protected $statuses = [
         'new_order' => ['en' => 'add new order', 'mm' => 'order အသစ်တစ်ခု ဖန်တီးခဲ့သည်။'],
         'change_order_note' => ['en' => 'change note', 'mm' => 'change order note'],
         'change_order_customer' => ['en' => 'change customer', 'mm' => 'change customer'],
         'change_order_total_overall_discount' => ['en' => 'change total overall discount', 'mm' => 'change total overall discount'],
         'delete_order' => ['en' => 'delete order', 'mm' => 'delete order'],
         'new_order_item' => ['en' => 'add new order item', 'mm' => 'add new order item'],
         'change_order_item_product' => ['en' => 'change product', 'mm' => 'change product'],
         'change_order_item_qty' => ['en' => 'change item qty', 'mm' => 'change item qty '],
         'change_order_item_discount' => ['en' => 'change item discount', 'mm' => 'change item discount'],
         'delete_order_item' => ['en' => 'delete order item', 'mm' => 'delete order item'],
        
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        foreach ($this->statuses as $value => $description) {
            LogStatus::create([
                'value'           => $value,
                'description'     => $description["en"],
                'description_mm'  => $description["mm"]
            ]);
        }
        Schema::enableForeignKeyConstraints();
    }
}
