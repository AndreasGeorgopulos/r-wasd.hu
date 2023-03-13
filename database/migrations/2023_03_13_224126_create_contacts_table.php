<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
	const TABLE_CONTACTS = 'contacts';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::TABLE_CONTACTS, function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('name');
			$table->string('email');
			$table->string('phone')->nullable();
			$table->tinyInteger('subject');
			$table->longText('message');
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
        Schema::dropIfExists(self::TABLE_CONTACTS);
    }
}
