<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('customer_no')->unique()->nullable();
            $table->string('membership_no')->unique()->nullable();
            $table->string('name');
            $table->string('phone')->unique();
            $table->string('another_phone')->nullable();
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->uuid('city_id');
            $table->uuid('zone_id');
            $table->string('address');
            $table->boolean('is_active')->default(false);
            $table->integer('sale_count')->nullable();
            $table->integer('order_count')->nullable();
            $table->string('created_by_type')->nullable();
            $table->string('updated_by_type')->nullable();
            $table->uuid('created_by_id')->nullable();
            $table->uuid('updated_by_id')->nullable();
            $table->uuid('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
        });
    }

  /**
   * 
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('customers');
        Schema::enableForeignKeyConstraints();
    }
}
