<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
	const TABLE_ORDERS = 'orders';
	const TABLE_POSTAL_PARCELS = 'postal_parcels';
	const TABLE_COUNTRIES = 'countries';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::TABLE_ORDERS, function (Blueprint $table) {
            $table->bigIncrements('id');
	        $table->bigInteger('postal_parcel_id', false, true)->nullable();
			$table->bigInteger('shipping_country_id', false, true)->nullable();
			$table->string('shipping_zip');
			$table->string('shipping_city');
			$table->string('shipping_address');
			$table->string('name');
			$table->string('email');
			$table->string('phone');
			$table->text('notice')->nullable();
	        $table->string('order_code')->nullable();
	        $table->string('postal_tracking_code')->nullable();
	        $table->text('paypal_response')->nullable();
            $table->timestamps();
			$table->softDeletes();

	        $table->foreign('postal_parcel_id', 'foreign_key_orders_postal_parcel_id_id')
				->references('id')
				->on(self::TABLE_POSTAL_PARCELS)
				->onDelete('cascade');

	        $table->foreign('shipping_country_id', 'foreign_key_orders_shipping_country_id_id')
		        ->references('id')
		        ->on(self::TABLE_COUNTRIES)
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
        Schema::dropIfExists(self::TABLE_ORDERS);
    }
}
