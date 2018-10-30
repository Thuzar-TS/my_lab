<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlipHeadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slip_headers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('location_id')->nullable();
            $table->integer('bin_id')->nullable();
            $table->string('test_date',10)->nullable();
            $table->decimal('discount_amt',18,2)->nullable();
            $table->decimal('discount_percent',18,2)->nullable();
            $table->decimal('total_amt',18,2)->nullable();
            $table->decimal('net_amt',18,2)->nullable();
            $table->integer('admission_id')->nullable();
            $table->integer('patient_id')->nullable();
            $table->integer('consultant_id')->nullable();
            $table->string('consultant_name')->nullable();
            $table->integer('room_number')->nullable();
            $table->integer('admission_type')->nullable();
            $table->integer('original_test_number')->nullable();
            $table->string('short_description')->nullable();
            $table->integer('status')->nullable();
            $table->text('remark')->nullable();
            $table->integer('user_id');
            $table->integer('recordstatus')->default(1);
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
        Schema::dropIfExists('slip_headers');
    }
}
