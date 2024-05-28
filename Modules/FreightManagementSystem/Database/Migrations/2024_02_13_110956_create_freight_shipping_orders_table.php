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
        if (!Schema::hasTable('freight_shipping_orders')) {
            Schema::create('freight_shipping_orders', function (Blueprint $table) {
                $table->id();
                $table->string('shipping_id')->nullable();
                $table->string('container_id')->nullable();
                $table->string('pricing_id')->nullable();
                $table->string('description')->nullable();
                $table->string('bill_on')->nullable();
                $table->string('weight')->nullable();
                $table->string('volume')->nullable();
                $table->decimal('price', 30, 2)->nullable()->default(0.0);
                $table->decimal('sale_price', 30, 2)->nullable()->default(0.0);
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
        Schema::dropIfExists('freight_shipping_orders');
    }
};
