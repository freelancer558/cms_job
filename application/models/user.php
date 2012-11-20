<?php 

class User extends Appmodel {

	public static $timestamps = true;

	public function repairs()
	{
		return $this->has_many('Repair');
	}

	public function requirements()
	{
		return $this->has_many('Requirement');
	}

	public function users_metadata()
	{
		return $this->has_one('UsersMetadata');
	}
	
	public function photos()
	{
		return $this->has_one('Photo');
	}
}
