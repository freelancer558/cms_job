<?php

class StatusRepair extends Appmodel {

	public static $timestamps = true;
	public static $table = 'status_repairs';
	
	public function repair(){
		return $this->belongs_to('Repair');
	}

}