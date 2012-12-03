<?php

class Add_Serial_No_To_Products {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('products', function($table){
			$table->string('serial_no');
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
			$table->drop_column('serial_no');
		});
	}

}