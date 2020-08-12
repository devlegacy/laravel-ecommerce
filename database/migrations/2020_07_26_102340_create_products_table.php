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
            $table->bigInteger('category_id')->unsigned();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->unsignedDecimal('price', 10, 4)->default(0.0000);
            $table->unsignedDecimal('discount', 10, 4)->default(0.0000);
            $table->unsignedDecimal('discount_price', 10, 4)->default(0.0000);
            $table->unsignedDecimal('vat', 10, 4)->default(0.0000);
            $table->unsignedDecimal('sub_total', 10, 4)->default(0.0000);
            $table->tinyInteger('discount_rate')->default(0); // 0-99
            $table->tinyInteger('vat_rate')->default(16); // 0-99
            $table->unsignedInteger('stock')->default(0);
            $table->tinyInteger('is_active')->default(1);

            $table->unique(['name'], 'uk_products_name');

            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->nullable();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'))->nullable();
        });

        DB::statement('ALTER TABLE `products` MODIFY COLUMN `vat_rate` TINYINT(2) UNSIGNED NOT NULL DEFAULT 16');
        DB::statement('ALTER TABLE `products` MODIFY COLUMN `discount_rate` TINYINT(2) UNSIGNED NOT NULL DEFAULT 0');
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
