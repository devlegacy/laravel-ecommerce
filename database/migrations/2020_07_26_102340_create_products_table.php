<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->decimal('price', 14, 4)->default(0.0000);
            $table->unsignedInteger('discount')->default(0);
            // $table->decimal('discount', 3, 2)->default(0.00); // price / discount -> 116 / 1.16 * 0.16
            $table->unsignedInteger('stock')->default(0);
            $table->unsignedTinyInteger('is_active')->default(1);

            $table->unique(['name'], 'uk_products_name');
            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
