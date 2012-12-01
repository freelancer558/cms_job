<?php

class Create_Add_Column_Repairs_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('repairs', function($table){
			$table->string('name');
			$table->string('setup_place');
			$table->text('detail');
			$table->drop_column('sypm');
			$table->drop_column('date');
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
			$table->drop_column('name');
			$table->drop_column('setup_place');
			$table->drop_column('detail');
			$table->string('sypm');
		});
	}

}