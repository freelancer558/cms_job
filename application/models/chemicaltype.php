<?php

class ChemicalType extends Appmodel {

	public static $timestamps = false;
	public static $table = 'chemical_types';

	public function chemicals_chemical_types()
	{
		return $this->has_many('ChemicalsChemicalType');
	}

}