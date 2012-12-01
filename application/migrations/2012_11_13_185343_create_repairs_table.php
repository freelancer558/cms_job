<?php

class Create_Repairs_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('repairs', function($table){
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->date('date');
		    $table->string('sypm');

		    $table->integer('user_id')->unsigned();
		    $table->integer('product_id')->unsigned();

		    $table->foreign('user_id')->references('id')->on('users')->on_delete('restrict');;
 			$table->foreign('product_id')->references('id')->on('products')->on_delete('restrict');;

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
		Schema::drop('repairs');
	}

}