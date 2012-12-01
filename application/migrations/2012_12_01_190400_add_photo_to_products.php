<?php

class Add_Photo_To_Products {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('photos', function($table){
			$table->integer('product_id')->unsigned();
	    	$table->foreign('product_id')->references('id')->on('products')->on_delete('restrict');
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('photos', function($table){
			$table->drop_foreign('photos_product_id_foreign');
			$table->drop_column('product_id');
		});
	}

}