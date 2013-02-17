<?php

class Add_Field_Invoice_Id_To_Repair_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('repairs', function($table){
			$table->string('invoice_id');
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
			$table->drop_column('invlice_id');
		});
	}

}