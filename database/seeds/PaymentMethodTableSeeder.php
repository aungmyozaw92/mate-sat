<?php

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodTableSeeder extends Seeder
{
     protected $data = [
        'Cash' ,
        'KBZ Bank' ,
        'KBZ PAY' ,
        'CB PAY' ,
        'CB Bank' ,
        'AYA PAY' ,
        'AYA Bank' ,
        'WavePay' ,
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
            PaymentMethod::create([
                'name' => $row
            ]);
        }
        Schema::enableForeignKeyConstraints();
    }
}
