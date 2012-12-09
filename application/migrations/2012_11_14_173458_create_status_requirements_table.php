<?php

class Create_Status_Requirements_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('status_requirements', function($table)
		{
			$table->engine = 'InnoDB';
		    $table->increments('id');
		    $table->string('name');
		   	
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
		Schema::drop('status_requirements');
	}

}