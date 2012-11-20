<?php

class Insert_Student_Code_To_Users_Metadata_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users_metadata', function($table){
			$table->string('student_code');
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
			$table->drop_column('student_code');
		});
	}

}