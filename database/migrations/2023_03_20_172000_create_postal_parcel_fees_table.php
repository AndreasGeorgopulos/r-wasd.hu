<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostalParcelFeesTable extends Migration
{
	const TABLE_POSTAL_PARCEL_FEES = 'postal_parcels_fees';
	const TABLE_POSTAL_PARCELS = 'postal_parcels';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::TABLE_POSTAL_PARCEL_FEES, function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->bigInteger('postal_parcel_id', false, true);
			$table->float('weight_from')->nullable();
			$table->float('weight_to')->nullable();
			$table->double('fee')->nullable();
            $table->timestamps();
            $table->softDeletes();

	        $table->foreign('postal_parcel_id', 'foreign_key_postal_parcel_fees_postal_parcel_id_id')
		        ->references('id')
		        ->on(self::TABLE_POSTAL_PARCELS)
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
        Schema::dropIfExists(self::TABLE_POSTAL_PARCEL_FEES);
    }
}
