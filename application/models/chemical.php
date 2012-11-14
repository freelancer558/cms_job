<?php
class Chemical extends Eloquent {
	public function chemical_type()
	{
		return $this->has_one('Chemical_Type');
	}
}