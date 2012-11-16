<?php

class Add_Users_Metadata {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users_metadata', function($table){
	    $table->string('address');
	    $table->integer('sex_type');
	    $table->string('telephone');
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users_metadata', function($table){
			$table->drop_column(array('address', 'sex_type', 'telephone'));
		});
	}

}