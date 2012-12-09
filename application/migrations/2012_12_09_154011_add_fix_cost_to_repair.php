<?php

class Add_Fix_Cost_To_Repair {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('repairs', function($table){
			$table->integer('fix_cost')->default(0);
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
			$table->drop_column('fix_cost');
		});
	}

}