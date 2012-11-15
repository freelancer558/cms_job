<?php

class Create_Users_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function($table)
		{
			$table->engine = 'InnoDB';
	    $table->increments('id');
	    $table->string('email');
	    $table->string('password');
	    $table->string('name');
	    $table->string('lastname');
	    $table->string('add');
	    $table->integer('sex_type');
	    $table->string('tel');

	    $table->integer('role_id')->unsigned();
	    $table->foreign('role_id')->references('id')->on('roles')->on_delete('restrict');

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
		Schema::drop('users');
	}

}