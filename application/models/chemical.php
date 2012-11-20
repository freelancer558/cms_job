<?php

class Chemical extends Appmodel {

	public static $timestamps = true;
	
	public function chemical_types()
	{
		return $this->has_many_and_belongs_to('Chemical_Type');
	}
	
	public function requirements()
	{
		return $this->has_many_and_belongs_to('Requirement');
	}

	public function photos()
  {
    return $this->has_many('Photo');
  }
  
}