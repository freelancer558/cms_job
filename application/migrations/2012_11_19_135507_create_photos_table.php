<?php

class Create_Photos_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('photos', function($table){
			$table->increments('id');
			$table->string('location');
			$table->string('description');

			$table->integer('chemical_id')->unsigned();
	    $table->foreign('chemical_id')->references('id')->on('chemicals')->on_delete('restrict');

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
		Schema::drop('photos');
	}

}