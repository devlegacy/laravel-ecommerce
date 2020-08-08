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
            $table->unsignedDecimal('price', 10, 4)->default(0.0000);
            $table->tinyInteger('percentage_discount'); // 00-99
            $table->unsignedInteger('stock')->default(0);
            $table->tinyInteger('is_active');

            $table->unique(['name'], 'uk_products_name');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });

        DB::statement('ALTER TABLE `products` MODIFY COLUMN `percentage_discount` TINYINT(2) UNSIGNED NOT NULL DEFAULT 0');
        DB::statement('ALTER TABLE `products` MODIFY COLUMN `is_active` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1');
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
