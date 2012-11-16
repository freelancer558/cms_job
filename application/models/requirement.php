<?php

class Requirement extends ActiveRecord\Model {

	public static $timestamps = true;

	public function chemicals()
	{
		return $this->has_many_and_belongs_to('Chemical');
	}

	public function status_requirement()
	{
		return $this->has_one('Status_Requirement');
	}

}
