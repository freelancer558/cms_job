<?php

class Add_Show_Low_To_Chemical {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('chemicals', function($table){
			$table->boolean('show_low')->default(true);
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
			$table->drop_column('show_low');
		});
	}

}