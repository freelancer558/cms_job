<?php
class Requirement extends Eloquent {
	public function chemicals()
	{
		return $this->has_many('Chemical');
	}
}