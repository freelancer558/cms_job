<?php

class Create_Requirements_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('requirements', function($table)
		{
			$table->engine = 'InnoDB';
	    $table->increments('id');
	    $table->date('date');

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
		Schema::drop('requirements');
	}

}