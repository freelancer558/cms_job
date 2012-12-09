<?php

class Add_Approved_User_To_Status_Requirements {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('status_requirements', function($table){
			$table->integer('user_id')->unsigned();
		    $table->foreign('user_id')->references('id')->on('users')->on_delete('restrict');
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('status_requirements', function($table){
			$table->drop_foreign('status_requirements_user_id_foreign');
			$table->drop_column('user_id');
		});
	}

}