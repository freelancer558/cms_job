<?php

class Change_Chemical_Type_Column {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('chemical_types', function($table){
			$table->drop_column('name');
		});

		Schema::table('chemical_types', function($table){
			$table->string('title');
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('chemical_types', function($table){
			$table->drop_column('title');
		});

		Schema::table('chemical_types', function($table){
			$table->string('name');
		});
	}

}