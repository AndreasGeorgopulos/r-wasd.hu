<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndexVideosTable extends Migration
{
	const TABLE_INDEX_VIDEOS = 'index_videos';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::TABLE_INDEX_VIDEOS, function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->bigInteger('sort')->default(0);
			$table->string('filename');
			$table->boolean('is_active')->default(true);
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
        Schema::dropIfExists(self::TABLE_INDEX_VIDEOS);
    }
}
