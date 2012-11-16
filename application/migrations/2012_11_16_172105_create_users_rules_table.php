<?php

class Create_Users_Rules_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users_rules', function($table){
			$table->engine = 'InnoDB';
			$table->increments('id');

			$table->integer('user_id')->unsigned();
	    $table->foreign('user_id')->references('id')->on('users')->on_delete('restrict');

			$table->integer('rule_id')->unsigned();
	    $table->foreign('rule_id')->references('id')->on('rules')->on_delete('restrict');	    

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
		Schema::drop('users_rules');
	}

}