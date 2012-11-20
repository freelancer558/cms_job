<?php

class UsersMetadata extends Eloquent {

	public static $timestamps = false;
	public static $table = 'users_metadata';
	public static $key = 'user_id';

	public function user()
	{
		return $this->belongs_to('User');
	}
}
