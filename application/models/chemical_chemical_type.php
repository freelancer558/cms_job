<?php

class Chemical_Chemical_Type extends Eloquent {

	public function chemical()
	{
		return $this->has_one('Chemical');
	}

	public function chemical_type()
	{
		return $this->has_one('Chemical_Type');
	}

}
