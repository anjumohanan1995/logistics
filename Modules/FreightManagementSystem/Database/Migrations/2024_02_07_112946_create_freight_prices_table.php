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
        if (!Schema::hasTable('freight_prices')) {
            Schema::create('freight_prices', function (Blueprint $table) {
                $table->id();
                $table->string('name')->nullable();
                $table->decimal('volume_price', 30, 2)->nullable()->default(0.0);
                $table->decimal('weight_price', 30, 2)->nullable()->default(0.0);
                $table->decimal('service_price', 30, 2)->nullable()->default(0.0);
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
        Schema::dropIfExists('freight_prices');
    }
};
