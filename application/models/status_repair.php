<?php

class Status_Repair extends ActiveRecord\Model {

	public static $timestamps = true;

	public function repair(){
		return $this->belongs_to('Repair');
	}

}