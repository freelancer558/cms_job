<?php

class Drop_Some_Column_Requirements {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('requirements', function($table){
			$table->drop_column('date');

			$table->integer('total');

			$table->integer('user_id')->unsigned();
		    $table->foreign('user_id')->references('id')->on('users')->on_delete('restrict');	    

		    $table->integer('chemical_id')->unsigned();
		    $table->foreign('chemical_id')->references('id')->on('chemicals')->on_delete('restrict');	    
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('requirements', function($table){
			$table->date('date');

			$table->drop_column('total');

			$table->drop_foreign('requirements_user_id_foreign');
			$table->drop_column('user_id');

			$table->drop_foreign('requirements_chemical_id_foreign');
			$table->drop_column('chemical_id');
		});
	}

}