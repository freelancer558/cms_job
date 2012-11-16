<?php namespace Admin; 
 class User extends Appmodel{ 
 	public static $table ='users';  
 	public $index= array();  
 	public $new=array();  
 	public $edit= array();  
 	public $show= array();  
 	public $rules= array();  
 }