<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->increments('id')->comment('Egyedi azonosító')->unique();
            $table->string('title')->comment('Megnevezés');
            $table->string('index_image_file_name')->comment('Index kép')->nullable();
            $table->integer('category')->comment('Kategória')->nullable();
            $table->text('description')->comment('Leírás')->nullable();
            $table->tinyInteger('type')->default('1')->comment('Típus: 1 - Site, 2 - Block, 3 - E-mail');
            $table->tinyInteger('active')->comment('Aktív');
            $table->tinyInteger('deletable')->comment('Törölhető');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('content_translates', function (Blueprint $table) {
            $table->increments('id')->comment('Egyedi azonosító')->unique();
            $table->integer('content_id')->comment('Oldal');
	        $table->string('slug')->comment('Slug')->nullable();
	        $table->text('lead')->comment('Bevezető')->nullable();
	        $table->text('body')->comment('Tartalom')->nullable();
            $table->string('meta_title')->comment('Meta Megnevezés')->nullable();
            $table->string('meta_image')->comment('Meta Kép')->nullable();
            $table->string('meta_description')->comment('Meta Leírás')->nullable();
            $table->string('meta_keywords')->comment('Meta Kulcsszavak')->nullable();
            $table->string('language_code')->comment('Nyelv');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('contents');
        Schema::drop('content_translates');
    }
}
