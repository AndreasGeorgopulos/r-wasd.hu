<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSortToProductImages extends Migration
{
	const TABLE_PRODUCT_IMAGES = 'product_images';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(self::TABLE_PRODUCT_IMAGES, function (Blueprint $table) {
	        $table->bigInteger('sort')->default(0)->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(self::TABLE_PRODUCT_IMAGES, function (Blueprint $table) {
	        $table->dropColumn([
		        'sort',
	        ]);
        });
    }
}
