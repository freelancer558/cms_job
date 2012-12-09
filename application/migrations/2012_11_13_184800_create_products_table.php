<?php

class Create_Products_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('products', function($table){
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->string('name');
		    $table->integer('sum');
		    $table->string('data');
		    $table->string('add');
		    $table->string('model');
		    $table->date('pay');

		    $table->timestamps();
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('products');
	}

}