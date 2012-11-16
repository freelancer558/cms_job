<?php

class LaraAdmin
{

	public static function make()
	{
		// Config::set('laraAdmin.models', array() );
		Config::set(
			'laraAdmin.models',
			array(
				"User", "Rule", "Group", "Chemical", "Product"
			)
		);
		Config::set('laraAdmin.title', "Lara Admin");
	}

}