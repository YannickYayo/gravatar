<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImageUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_images', function($t) {
			$t->increments('id');
			$t->string('email',100)->unique();
			$t->string('image',100);
			$t->timestamps();
			//$t->foreign('email')->references('email')->on('users');
		});
		Schema::table('user_images', function($t) {
			$t->foreign('email')->references('email')->on('users')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user_images');
	}

}
