<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {


			$table->id();
			$table->string('name')->comment('Name of the store');
			$table->unsignedInteger('user_id')->comment('Owner id of the store');
			$table->double('shipping_cost')->nullable()->comment('Optional shipping cost');
            $table->double('vat_percentage')->nullable()->comment('Optional VAT percentage on store product');
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
        Schema::dropIfExists('stores');
    }
}
