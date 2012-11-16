<?php

class Chemical extends ActiveRecord\Model {

	public static $timestamps = true;
	
	public function chemical_type()
	{
		return $this->has_one('Chemical_Type');
	}
	
	public function requirements()
	{
		return $this->has_many_and_belongs_to('Requirement');
	}

}