<?php

class Product extends Appmodel {

	public static $timestamps = true;

	public function repair()
	{
		return $this->belongs_to('Repair');
	}

}
