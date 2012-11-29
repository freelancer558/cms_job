<?php

class Remove_Column_Add_Product {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('products', function($table){
			$table->drop_column('add');
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
			$table->date('add');
		});
	}

}