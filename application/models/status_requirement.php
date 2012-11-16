<?php

class Status_Requirement extends ActiveRecord\Model {

	public static $timestamps = true;

	public function requirement()
	{
		return $this->belongs_to('Requirement');
	}

}