<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderItemsTable extends Migration
{
	const TABLE_ORDERS = 'orders';
	const TABLE_ORDER_ITEMS = 'order_items';
	const TABLE_PRODUCTS = 'products';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::TABLE_ORDER_ITEMS, function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->bigInteger('order_id', false, true);
			$table->bigInteger('product_id', false, true);
			$table->float('unit_price');
			$table->integer('amount');
            $table->timestamps();
			$table->softDeletes();

	        $table->foreign('order_id', 'foreign_key_order_items_order_id_id')
		        ->references('id')
		        ->on(self::TABLE_ORDERS)
		        ->onDelete('cascade');

	        $table->foreign('product_id', 'foreign_key_order_items_product_id_id')
		        ->references('id')
		        ->on(self::TABLE_PRODUCTS)
		        ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(self::TABLE_ORDER_ITEMS);
    }
}
