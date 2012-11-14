<?php
class Status_Repair extends Eloquent {
	public function repair(){
		return $this->belongs_to('Repair');
	}
}