<?php

class Create_Chemicals_Chemical_Types_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('chemicals_chemical_types', function($table){
			$table->engine = 'InnoDB';
			$table->increments('id');

			$table->integer('chemical_id')->unsigned();
	    $table->foreign('chemical_id')->references('id')->on('chemicals')->on_delete('restrict');

			$table->integer('chemical_type_id')->unsigned();
	    $table->foreign('chemical_type_id')->references('id')->on('chemical_types')->on_delete('restrict');	    
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
		Schema::drop('chemical_chemical_type');
	}

}