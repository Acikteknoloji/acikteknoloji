<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('notifications',function($table){
			$table->increments('id');
			$table->boolean('type');
			$table->integer('user_id')->unsigned();
			$table->string('action_name');
			$table->string('actor_name');
			$table->integer('isRead')->default(0);
			$table->timestamps();

			$table->foreign('user_id')->references('id')->on('users');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('notifications',function($table){
			$table->dropForeign('notifications_user_id_foreign');
		});
		Schema::drop('notifications');
	}

}
