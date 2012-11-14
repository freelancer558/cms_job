<?php
class Status_Requirement extends Eloquent {
	public function requirement()
	{
		return $this->belongs_to('Requirement');
	}
}