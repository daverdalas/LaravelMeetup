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
        $user = new \App\User();
        $user->name = 'Janusz Użytkownik';
        $user->email = 'janusz@januszowo.pl';
        $user->is_admin = 0;
        $user->password = \Hash::make('password');
        $user->save();

        $user = new \App\User();
        $user->name = 'Admin';
        $user->email = 'admin@example.com';
        $user->is_admin = 1;
        $user->password = \Hash::make('password');
        $user->save();
    }
}
