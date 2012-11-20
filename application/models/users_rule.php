<?php

class Users_Rule extends Eloquent {
	public function rule()
	{
		return $this->belongs_to('Rule');
	}
}
