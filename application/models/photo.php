<?php

class Photo extends Eloquent
{
	public static $timestamps = true;
	public static $table = 'photos';
	
	public function chemical()
	{
		// public static $key = 'chemical_id';
		return $this->belongs_to('Chemical');
	}

	public function user()
	{
		// public static $key = 'user_id';
		return $this->belongs_to('User');
	}

	public function products()
	{
		return $this->belongs_to('Product');
	}
}
