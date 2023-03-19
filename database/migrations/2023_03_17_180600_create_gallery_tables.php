<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGalleryTables extends Migration
{
	const TABLE_PRODUCT_IMAGES = 'product_images';
	const TABLE_PRODUCTS = 'products';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create(self::TABLE_PRODUCT_IMAGES, function (Blueprint $table) {
		    $table->bigIncrements('id');
		    $table->bigInteger('product_id', false, true);
		    $table->string('file_name')->nullable();
		    $table->string('file_type')->nullable();
		    $table->tinyInteger('active')->default(1)->comment('Aktív');
		    $table->timestamps();
		    $table->softDeletes();

		    $table->foreign('product_id', 'foreign_key_product_images_product_id_id')
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
	    Schema::dropIfExists(self::TABLE_PRODUCT_IMAGES);
    }
}
