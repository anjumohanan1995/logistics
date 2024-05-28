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
        if (!Schema::hasTable('freight_invoices')) {
            Schema::create('freight_invoices', function (Blueprint $table) {
                $table->id();
                $table->string('code')->nullable();
                $table->string('shipping_id')->nullable();
                $table->string('customer_id')->nullable();
                $table->string('status')->nullable();
                $table->string('amount')->nullable();
                $table->date('invoice_date')->nullable();
                $table->date('due_date')->nullable();
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
        Schema::dropIfExists('freight_invoices');
    }
};
