<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSlugAndSubtitleIdToPostsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('posts',function($table){
			$table->integer('subtitle_id')->unsigned();
			$table->foreign('subtitle_id')->references('id')->on('subtitles');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('posts',function($table){
			$table->dropForeign('posts_subtitle_id_foreign');
		});
		Schema::drop('posts');
	}

}
