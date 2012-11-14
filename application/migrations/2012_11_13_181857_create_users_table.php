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
	    $table->string('name');
	    $table->string('lastname');
	    $table->string('add');
	    $table->string('sex');
	    $table->integer('sex_type');
	    $table->string('tel');
	    $table->string('mail');
	    $table->integer('typel');

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