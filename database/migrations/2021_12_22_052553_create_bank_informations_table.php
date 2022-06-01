<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_informations', function (Blueprint $table) {
            $table->uuid('id')->primary();            
            $table->string('account_name');
            $table->string('account_no');
            $table->uuid('bank_id');
            $table->string('resourceable_type');
            $table->uuid('resourceable_id');
            $table->boolean('is_default')->default(false);
            $table->string('branch_name')->nullable();
            $table->string('created_by_type')->nullable();
            $table->string('updated_by_type')->nullable();
            $table->string('deleted_by_type')->nullable();
            $table->uuid('created_by_id')->nullable();
            $table->uuid('updated_by_id')->nullable();
            $table->uuid('deleted_by_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bank_informations');
    }
}
