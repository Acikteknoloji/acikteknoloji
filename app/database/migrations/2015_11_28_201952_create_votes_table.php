<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVotesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('votes',function($table){
			$table->increments('id');
			$table->boolean('vote');
			$table->integer('user_id')->unsigned();
			$table->integer('post_id')->unsigned();

			$table->foreign('user_id')->references('id')->on('users');
			$table->foreign('post_id')->references('id')->on('posts');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('votes',function($table){
			$table->dropForeign('votes_user_id_foreign');
			$table->dropForeign('votes_post_id_foreign');
		});
		Schema::drop('votes');
	}

}
