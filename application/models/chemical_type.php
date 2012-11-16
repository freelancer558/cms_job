<?php

class Chemical_Type extends Appmodel {

	public static $timestamps = true;

	public function chemicals()
	{
		return $this->has_many_and_belongs_to('Chemical');
	}

}