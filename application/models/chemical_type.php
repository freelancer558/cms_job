<?php

class Chemical_Type extends ActiveRecord\Model {

	public static $timestamps = true;

	public function chemical()
	{
		return $this->belongs_to('Chemical');
	}

}