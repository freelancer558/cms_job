<?php

class Create_Chemicals_Requirements_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('chemicals_requirements', function($table)
		{
			$table->engine = 'InnoDB';
			$table->increments('id');

			$table->integer('chemical_id')->unsigned();
	    	$table->foreign('chemical_id')->references('id')->on('chemicals')->on_delete('restrict');

			$table->integer('requirement_id')->unsigned();
	    	$table->foreign('requirement_id')->references('id')->on('requirements')->on_delete('restrict');	    

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
		Schema::drop('chemicals_requirements');
	}

}