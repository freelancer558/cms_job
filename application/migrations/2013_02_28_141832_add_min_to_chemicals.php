<?php

class Add_Min_To_Chemicals {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('chemicals', function($table){
			$table->integer('minimum')->default(0);
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('chemicals', function($table){
			$table->drop_column('minimum');
		});
	}

}