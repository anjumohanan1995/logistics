<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('freight_booking_requests')) {
            Schema::create('freight_booking_requests', function (Blueprint $table) {
                $table->id();
                $table->string('user_id')->nullable();
                $table->string('code')->nullable();
                $table->string('status')->nullable();
                $table->string('is_convert')->nullable();
                $table->string('convert_shipping_id')->nullable();
                $table->string('customer_name')->nullable();
                $table->string('customer_email')->nullable();
                $table->string('direction')->nullable();
                $table->string('transport')->nullable();
                $table->string('loading_port')->nullable();
                $table->string('discharge_port')->nullable();
                $table->string('vessel')->nullable();
                $table->date('date')->nullable();
                $table->string('barcode')->nullable();
                $table->string('tracking_no')->nullable();
                $table->string('attechment')->nullable();
                $table->integer('workspace')->nullable();
                $table->integer('created_by')->default('0');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('freight_booking_requests');
    }
};
