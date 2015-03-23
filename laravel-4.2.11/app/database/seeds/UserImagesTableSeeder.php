<?php

class UserImagesTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_images')->delete();
        User_image::create(array(
            'email' => 'ecuzacq22@gmail.com',
            'image' => 'logo.png',
        ));
    }

}