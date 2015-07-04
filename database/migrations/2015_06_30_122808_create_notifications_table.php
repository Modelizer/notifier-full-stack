<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('notifications', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->bigInteger('sender_id')
				->foreign()
				->refrences('users')
				->on('id'); // foreign id
			
			$table->bigInteger('recipient_id')
				->foreign()
				->refrences('users')
				->on('id'); // foreign id
				
			$table->bigInteger('notifiable_id');
			$table->string('notifiable_type', 50);
			$table->string('title');
			$table->text('message');
			$table->enum('is_read', ['no', 'yes']);
			
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('notifications');
	}
}
