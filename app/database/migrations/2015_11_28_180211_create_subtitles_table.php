<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubtitlesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('subtitles',function($table){
			$table->increments('id');
			$table->string('name');
			$table->text('customcss');
			$table->text('unvalidcustomcss');
			$table->integer('user_id')->unsigned();
			$table->string('description',96);
			$table->boolean('active')->default(0);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('subtitles');
	}

}
