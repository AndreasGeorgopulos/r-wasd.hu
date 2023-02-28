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
	        $table->bigIncrements('id')->comment('Egyedi azonosító');
	        $table->string('title')->comment('Megnevezés');
	        $table->string('index_image_file_name')->comment('Index kép')->nullable();
	        $table->double('price')->comment('Ár')->nullable();
	        $table->double('weight')->comment('Súly')->nullable();
	        $table->tinyInteger('active')->comment('Aktív');
	        $table->timestamps();
	        $table->softDeletes();
        });

	    Schema::create('product_translates', function (Blueprint $table) {
		    $table->bigIncrements('id')->comment('Egyedi azonosító')->unique();
		    $table->bigInteger('product_id', false, true)->comment('Oldal');
		    $table->string('slug')->comment('Slug')->nullable();
		    $table->text('lead')->comment('Bevezető')->nullable();
		    $table->text('body')->comment('Tartalom')->nullable();
		    $table->string('meta_title')->comment('Meta Megnevezés')->nullable();
		    $table->string('meta_image')->comment('Meta Kép')->nullable();
		    $table->string('meta_description')->comment('Meta Leírás')->nullable();
		    $table->string('meta_keywords')->comment('Meta Kulcsszavak')->nullable();
		    $table->string('language_code')->comment('Nyelv');
		    $table->timestamps();
		    $table->softDeletes();

		    /*$table->foreign('product_id', 'foreign_key_product_translates_product_id')
			    ->references('id')
			    ->on('products')
			    ->onDelete('cascade');*/
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_translates');
        Schema::dropIfExists('products');
    }
}
