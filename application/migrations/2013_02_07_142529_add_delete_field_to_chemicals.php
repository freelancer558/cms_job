<?php

class Add_Delete_Field_To_Chemicals {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('chemicals', function($table){
			$table->boolean('remove')->default(false);
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
			$table->drop_column('remove');
		});
	}

}