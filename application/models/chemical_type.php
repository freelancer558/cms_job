<?php
class Chemical_Type extends Eloquent {
	public function chemical()
	{
		return $this->belongs_to('Chemical');
	}
}