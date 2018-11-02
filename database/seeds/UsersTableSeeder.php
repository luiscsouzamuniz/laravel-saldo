<?php

use Illuminate\Database\Seeder;
use App\User;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::create([
        	'name'     => 'Luis Carlos de Souza',
        	'email'    => 'luisc.souzamuniz@gmail.com',
        	'password' => bcrypt('123456'),

        ]);

        User::create([
            'name'     => 'Roselane Pereira',
            'email'    => 'rosyemipereira@hotmail.com',
            'password' => bcrypt('123456'),

        ]);
    }
}
