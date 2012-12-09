<?php

class Remove_Total_From_Product {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('products', function($table){
			$table->drop_column('sum');
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
			$table->integer('sum');
		});
	}

}