<?php

class Change_Column_Date_On_Repair_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('repairs', function($table){
			$table->string('date');
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('repairs', function($table){
			$table->drop_column('date');
		});
	}

}