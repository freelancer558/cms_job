<?php

class Status_Requirement extends Appmodel {

	public static $timestamps = true;

	public function requirement()
	{
		return $this->belongs_to('Requirement');
	}

}