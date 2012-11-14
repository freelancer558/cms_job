<?php

class Create_Status_Repairs_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('status_repairs', function($table)
		{
			$table->engine = 'InnoDB';
	    $table->increments('id');
	    $table->string('title');
	   	
	   	$table->integer('repair_id')->unsigned();
	    $table->foreign('repair_id')->references('id')->on('repairs')->on_delete('restrict');

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
		Schema::drop('status_repairs');
	}

}