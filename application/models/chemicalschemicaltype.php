<?php

class ChemicalsChemicalType extends Eloquent {
	public static $timestamps = false;
	public static $table = 'chemicals_chemical_types';

	public function chemical()
	{
		return $this->belongs_to('Chemical');
	}

	public function chemical_type()
	{
		return $this->has_one('ChemicalType');
	}

}
