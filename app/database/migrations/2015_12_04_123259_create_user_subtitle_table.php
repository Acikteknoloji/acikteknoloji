<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserSubtitleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_subtitle',function($table){
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->integer('subtitle_id')->unsigned();
			$table->boolean('isAdmin')->default(0);

			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->foreign('subtitle_id')->references('id')->on('subtitles')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('user_subtitle',function($table)
		{
			$table->dropForeign('user_subtitle_user_id_foreign');
			$table->dropForeign('user_subtitle_subtitle_id_foreign');
		});
		Schema::drop('user_subtitle');
	}

}
