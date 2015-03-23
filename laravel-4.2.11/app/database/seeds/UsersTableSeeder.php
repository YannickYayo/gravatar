<?php

class UsersTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        User::create(array(
            'username' => 'demo',
            'password' => Hash::make('demo6440'),
            'email'=>'test@test.fr',
        ));
        User::create(array(
        		'username' => 'manu',
        		'password' => Hash::make('manu'),
        		'email'=>'ecuzacq22@gmail.com',
        ));
    }

}