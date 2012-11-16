<?php

class Create_Chemical_Types_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('chemical_types', function($table)
		{
			$table->engine = 'InnoDB';
	    $table->increments('id');
	    $table->string('name');
	    
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
		Schema::drop('chemical_types');
	}

}