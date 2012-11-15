<?php

class Status_Repair extends Eloquent {

	public static $timestamps = true;

	public function repair(){
		return $this->belongs_to('Repair');
	}

}