<?php

class StatusRequirement extends Appmodel {

	public static $timestamps = true;
	public static $table = 'status_requirements';
	
	public function requirement()
	{
		return $this->belongs_to('Requirement');
	}

}