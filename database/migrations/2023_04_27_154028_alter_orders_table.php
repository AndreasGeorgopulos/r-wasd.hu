<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterOrdersTable extends Migration
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
		    $table->tinyInteger('status')
			    ->default(1)
			    ->comment('1 - New, 2 - Sent, 3 - Done')
			    ->after('paypal_response');
			$table->text('postal_notice')->nullable()->after('postal_tracking_code');
			$table->text('finish_notice')->nullable()->after('postal_notice');
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
			    'status',
			    'postal_notice',
			    'finish_notice',
		    ]);
	    });
    }
}
