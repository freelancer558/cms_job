<?php

class Status_Repair extends Appmodel {

	public static $timestamps = true;

	public function repair(){
		return $this->belongs_to('Repair');
	}

}