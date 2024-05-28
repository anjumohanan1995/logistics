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
        if (!Schema::hasTable('freight_containers')) {
            Schema::create('freight_containers', function (Blueprint $table) {
                $table->id();
                $table->string('code')->nullable();
                $table->string('container_number')->nullable();
                $table->string('name')->nullable();
                $table->string('size')->nullable();
                $table->string('size_uom')->nullable();
                $table->decimal('volume_price', 30, 2)->nullable()->default(0.0);
                $table->string('status')->nullable();
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
        Schema::dropIfExists('freight_containers');
    }
};
