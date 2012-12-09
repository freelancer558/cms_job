<?php

class Chemical extends Appmodel {

	public static $timestamps = true;

	public function chemicals_chemical_type()
	{
		return $this->has_one('ChemicalsChemicalType');
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