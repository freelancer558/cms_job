<?php 

class User extends ActiveRecord\Model {

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
