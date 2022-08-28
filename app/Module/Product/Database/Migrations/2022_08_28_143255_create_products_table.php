<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            

			$table->id();
			$table->json('name')->comment('Name of the product');
			$table->unsignedInteger('store_id')->comment('Store id');
			$table->double('price')->comment('price of the product');
			$table->boolean('vat_included')->default('0')->comment('is vat included in the price of the product');
			$table->timestamps();

			$table->softDeletes();
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
