<?php

class Change_Exp_Mfd_Column {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('chemicals', function($table){
			$table->drop_column('mfd');
			$table->drop_column('exp');
		});

		Schema::table('chemicals', function($table){
			$table->string('mfd');
			$table->string('exp');
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('chemicals', function($table){
			$table->drop_column('mfd');
			$table->drop_column('exp');
		});
		
		Schema::table('chemicals', function($table){
			$table->date('mfd');
			$table->date('exp');
		});
	}

}