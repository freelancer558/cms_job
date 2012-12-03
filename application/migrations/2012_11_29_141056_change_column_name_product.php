<?php

class Change_Column_Name_Product {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('products', function($table){
			$table->drop_column('pay');
			$table->string('disburse');
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('products', function($table){
			$table->date('pay');
			$table->drop_column('disburse');
		});
	}

}