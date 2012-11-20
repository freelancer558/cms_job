<?php namespace Admin; 
class User extends Appmodel{ 
 	public static $table ='users';  
 	public $index= array(
 		"id",
 		"username",
 		"email",
 		"metadata.first_name" => array("title" => "First Name"),
 	);  
 	public $new=array(
 		"username", 
 		"email", 
 		"password",
 		// "password_confirmation",
 		"metadata.first_name",
 		
 	);  
 	public $edit= array();  
 	public $show= array();  
 	public $rules=array(
 		// "username" 	=> "required",
 		'email' 		=> 'required|email|unique:users',
 		// 'password'	=> 'required|confirmed',
 	);

}