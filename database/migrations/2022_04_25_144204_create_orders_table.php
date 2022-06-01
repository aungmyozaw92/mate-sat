<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('order_no')->unique()->nullable()->index('order_no');
            $table->uuid('customer_id')->index('customer_id');
            $table->string('customer_name')->nullable()->index('customer_name');
            $table->string('customer_phone')->nullable()->index('customer_phone');
            $table->string('customer_address')->nullable()->index('customer_address');
            $table->string('customer_city_name')->nullable()->index('customer_city_name');
            $table->string('customer_zone_name')->nullable()->index('customer_zone_name');
            $table->decimal('total_qty', 16, 2)->default(0);
            $table->decimal('total_price', 16, 2)->default(0);
            $table->decimal('total_amount', 16, 2)->default(0);
            $table->decimal('total_product_discount', 16, 2)->default(0);
            $table->decimal('total_overall_discount', 16, 2)->default(0);
            $table->decimal('grand_total_amount', 16, 2)->default(0);
            $table->boolean('status')->default(false);
            $table->string('type')->nullable();
            $table->string('note')->nullable();
            $table->longText('delivery_address')->nullable();
            $table->uuid('created_by')->nullable()->index('created_by');
            $table->uuid('updated_by')->nullable()->index('updated_by');
            $table->uuid('deleted_by')->nullable()->index('deleted_by');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('orders');
        Schema::enableForeignKeyConstraints();
    }
}
