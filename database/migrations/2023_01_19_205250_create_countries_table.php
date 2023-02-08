<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountriesTable extends Migration
{
	const TABLE_COUNTRIES = 'countries';
	const TABLE_POSTAL_PARCELS = 'postal_parcels';
	const TABLE_POSTAL_PARCELS_COUNTRIES = 'postal_parcels_countries';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::TABLE_COUNTRIES, function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('code', 3);
			$table->string('name', 100);
			$table->boolean('is_active');
            $table->timestamps();
            $table->softDeletes();
        });

	    Schema::create(self::TABLE_POSTAL_PARCELS, function (Blueprint $table) {
		    $table->bigIncrements('id');
		    $table->string('name', 100);
		    $table->boolean('is_active');
		    $table->timestamps();
		    $table->softDeletes();
	    });

	    Schema::create(self::TABLE_POSTAL_PARCELS_COUNTRIES, function (Blueprint $table) {
		    $table->bigInteger('postal_parcel_id', false, true);
		    $table->bigInteger('country_id', false, true);

		    $table->foreign('postal_parcel_id', 'foreign_key_postal_parcel_id_id')
				->references('id')
				->on(self::TABLE_POSTAL_PARCELS)
				->onDelete('cascade');

		    $table->foreign('country_id', 'foreign_key_country_id_id')
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
        Schema::dropIfExists(self::TABLE_POSTAL_PARCELS_COUNTRIES);
        Schema::dropIfExists(self::TABLE_POSTAL_PARCELS);
        Schema::dropIfExists(self::TABLE_COUNTRIES);
    }
}
