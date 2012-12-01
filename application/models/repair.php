<?php

class Repair extends Appmodel {	

	public static $timestamps = true;
	public static $table = 'repairs';
	public function products()
	{
		return $this->has_many('Product');
	}
	
	public function status_repair()
	{
		return $this->has_one('Status_Repair');
	}

	public function user()
	{
		return $this->belongs_to('User', 'user_id');
	}

}