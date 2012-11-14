<?php

class Create_Roles_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('roles', function($table)
		{
			$table->engine = 'InnoDB';
	    $table->increments('id');
	    $table->string('title');
	   	
	   	$table->integer('user_id')->unsigned();
	    $table->foreign('user_id')->references('id')->on('users')->on_delete('restrict');

	    $table->timestamps();	
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('roles');
	}

}