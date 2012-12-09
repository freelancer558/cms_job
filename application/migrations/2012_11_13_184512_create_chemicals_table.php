<?php

class Create_Chemicals_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('chemicals', function($table){
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->string('name');
		    $table->integer('sum');
		    $table->date('mfd');
		    $table->date('exp');
		    $table->string('add');

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
		Schema::drop('chemicals');
	}

}