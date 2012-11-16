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

}
