<?php

class Chemical_Type extends Eloquent {

	public static $timestamps = true;

	public function chemical()
	{
		return $this->belongs_to('Chemical');
	}

}