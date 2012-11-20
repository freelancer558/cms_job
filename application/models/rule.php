<?php

class Rule extends Eloquent {
	public static $timestamps = false;

	public function users_rule()
	{
		return $this->has_one('UsersRule');
	}
}
