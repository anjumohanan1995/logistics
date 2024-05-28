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
        if (!Schema::hasTable('freight_payments')) {
            Schema::create('freight_payments', function (Blueprint $table) {
                $table->id();
                $table->string('invoice_id')->nullable();
                $table->date('date')->nullable();
                $table->string('amount')->nullable();
                $table->string('description')->nullable();
                $table->string('reference')->nullable();
                $table->string('add_receipt')->nullable();
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
        Schema::dropIfExists('freight_payments');
    }
};
