<?php

class Sessions_Controller extends Base_Controller {

	var $layout = "layouts.sessions.default";

	public function __construct()
	{
		parent::__construct(); // Our layout will still be instantiated now.
		$this->filter('before', 'auth')->except(array("index", "destroy", "create"));
	}

	public function action_index()
	{
		$view = View::make("sessions.index");
		$this->layout->content = $view;

		return $this->layout;
	}

	public function action_destroy()
	{
		Session::forget("token_user");

		return Redirect::to("/user/login");
	}

	public function action_create()
	{
		$login = Input::get("login");
		$password = md5(Input::get("password"));

		if ($login == Config::get("lara_admin::lara_admin.user") && $password == Config::get("lara_admin::lara_admin.password")) {
			Session::put('token_user', md5("12324564567wefsdfsdf" . Config::get("bundle::lara_admin.user")));

			return Redirect::to("/");
		} else {
			return Redirect::to("/user/login");
		}
	}

}
