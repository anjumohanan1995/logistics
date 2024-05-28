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
        if (!Schema::hasTable('freight_shipping_routes')) {
            Schema::create('freight_shipping_routes', function (Blueprint $table) {
                $table->id();
                $table->string('shipping_id')->nullable();
                $table->string('route_operation')->nullable();
                $table->string('source_location')->nullable();
                $table->string('destination_location')->nullable();
                $table->string('transport')->nullable();
                $table->date('send_date')->nullable();
                $table->date('received_date')->nullable();
                $table->decimal('cost_price', 30, 2)->nullable()->default(0.0);
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
        Schema::dropIfExists('freight_shipping_routes');
    }
};
