<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBottleReturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('bottle_returns', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('sale_id');
            $table->uuid('sale_item_id');
            $table->uuid('product_id');
            $table->uuid('customer_id');
            $table->decimal('total_bottle', 16, 2)->default(0);
            $table->decimal('returned_bottle', 16, 2)->default(0);
            $table->decimal('remain_bottle', 16, 2)->default(0);
            $table->boolean('status')->default(false);
            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->uuid('deleted_by')->nullable();
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
        Schema::dropIfExists('bottle_returns');
        Schema::enableForeignKeyConstraints();
    }
}
