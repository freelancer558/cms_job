<?php 

class User extends Eloquent {

	public static $timestamps = true;
	
	public function role()
	{
		return $this->has_one('Role');
	}

	public function repairs()
	{
		return $this->has_many('Repair');
	}

	public function requirements()
	{
		return $this->has_many('Requirement');
	}

}
