<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFeeToOrdersTable extends Migration
{
	const TABLE_ORDERS = 'orders';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::table(self::TABLE_ORDERS, function (Blueprint $table) {
		    $table->float('postal_fee')->nullable()->after('postal_parcel_id');
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::table(self::TABLE_ORDERS, function (Blueprint $table) {
		    $table->dropColumn([
			    'postal_fee',
		    ]);
	    });
    }
}
