<?php

class Product extends Eloquent {

	public static $timestamps = true;

	public function repair()
	{
		return $this->belongs_to('Repair');
	}

}
