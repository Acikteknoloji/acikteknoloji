<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('posts',function($table){
			$table->increments('id');
			$table->string('title')->nullable();
			$table->text('content');
			$table->integer('user_id')->unsigned();
			$table->integer('isComment')->default(0);
			$table->text('isLink')->nullable()->default(null);
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
			$table->dropForeign('posts_user_id_foreign');
		});
		Schema::drop('posts');
	}

}
