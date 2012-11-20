<?php

class Photo extends Eloquent
{
	public static $timestamps = true;

	public function chemical()
	{
		public static $key = 'chemical_id';
		return $this->belongs_to('Chemical');
	}

	public function user()
	{
		public static $key = 'user_id';
		return $this->belongs_to('User');
	}
}
