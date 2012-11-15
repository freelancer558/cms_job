<?php

class Repair extends Eloquent {	

	public static $timestamps = true;
	
	public function products()
	{
		return $this->has_many('Product');
	}
	
	public function status_repair()
	{
		return $this->has_one('Status_Repair')
	}

}