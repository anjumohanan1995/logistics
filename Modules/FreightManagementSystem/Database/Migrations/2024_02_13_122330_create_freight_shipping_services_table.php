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
        if (!Schema::hasTable('freight_shipping_services')) {
            Schema::create('freight_shipping_services', function (Blueprint $table) {
                $table->id();
                $table->string('shipping_id')->nullable();
                $table->string('route_id')->nullable();
                $table->string('vendor')->nullable();
                $table->string('service')->nullable();
                $table->string('qty')->nullable();
                $table->decimal('sale_price', 30, 2)->nullable()->default(0.0);
                $table->decimal('cost_price', 30, 2)->nullable()->default(0.0);
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
        Schema::dropIfExists('freight_shipping_services');
    }
};
