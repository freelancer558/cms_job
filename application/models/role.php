<?php

class Role extends ActiveRecord\Model {

	public static $timestamps = true;

	public function users()
	{
		return $this->has_many('User');
	}

}
