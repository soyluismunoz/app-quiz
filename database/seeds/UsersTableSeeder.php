<?php

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
        factory(App\User::class, 5)->create();

        DB::table('users')->insert([
            'name'              => 'Perron User',
            'email'             => 'perron@mail.com',
            'role'              => 'admin',
            'email_verified_at' => now(),
            'password'          => Hash::make('tabienperron'),
            'created_at'        => now(),
            'updated_at'        => now()
        ]);
    }
}
