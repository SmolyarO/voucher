<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'       => env('ROOT_ADMIN_NAME'),
            'email'      => env('ROOT_ADMIN_EMAIL'),
            'password'   => Hash::make(env('ROOT_ADMIN_PASSWORD')),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
