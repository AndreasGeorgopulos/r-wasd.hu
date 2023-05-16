<?php

use Database\Seeders\IndexVideoSeed;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(DefaultDataSeeder::class);
        //$this->call(CountrySeeder::class);
        //$this->call(PostalParcelSeeder::class);
        //$this->call(ContentSeeder::class);
        //$this->call(PostalParcelFeeSeeder::class);
        $this->call(IndexVideoSeed::class);
    }
}
