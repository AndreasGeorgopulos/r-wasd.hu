<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DefaultDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'lastname' => 'Administrator',
            'firstname' => 'Super',
            'email' => 'admin@r-wasd.com',
            'password' => bcrypt('aA123456'),
            'created_at' => date("Y-m-d H:i:s")
        ]);

        DB::table('roles')->insert([
            'key' => 'superadmin',
        ]);

        DB::table('roles')->insert([
            'key' => 'login',
        ]);

        DB::table('role_user')->insert([
            'user_id' => 1,
            'role_id' => 1
        ]);

        DB::table('role_user')->insert([
            'user_id' => 1,
            'role_id' => 2
        ]);

        DB::table('contents')->insert([
            'title' => 'Kezdőlap',
            'category' => 0,
            'active' => 1
        ]);

        DB::table('content_translates')->insert(
            [
                'content_id' => 1,
                'meta_title' => 'Kezdőlap',
                'language_code' => 'hu'
            ]
        );

        DB::table('lq_options')->insert(
            [
                'lq_key' => 'analytics',
                'lq_value' => '<script type="text/javascript"></script>'
            ]
        );

        DB::table('lq_options')->insert(
            [
                'lq_key' => 'socials_facebook',
                'lq_value' => '#'
            ]
        );
        DB::table('lq_options')->insert(
            [
                'lq_key' => 'socials_google',
                'lq_value' => '#'
            ]
        );
        DB::table('lq_options')->insert(
            [
                'lq_key' => 'socials_instagram',
                'lq_value' => '#'
            ]
        );
        DB::table('lq_options')->insert(
            [
                'lq_key' => 'socials_youtube',
                'lq_value' => '#'
            ]
        );
    }
}
