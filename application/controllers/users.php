<?php

class Users_Controller extends Base_Controller
{
  var $layout = "layouts.application";
  public $restful = true;
  public function get_index()
  {
    $users = User::all();

    return View::make('users.index', array('users' => $users));
  }
  public function get_show()
  {
    $params = Request::route()->parameters;
    $user = Sentry::user((int)$params[0]);
    return View::make('users.show', array('user' => $user));
  }
  public function get_new()
  {
    $user = new User();

    $form = Formly::make($user);
    $form->form_class = 'form-horizontal';
    $form->auto_token = false;

    $g = [];
    foreach(Sentry::group()->all() as $group => $value){
      $g[$value['id']] = $value['name'];
    }
    return View::make('users.new', array('user' => $user, 'group' => $g))->with('form', $form);
  }

  public function get_edit()
  {
    $params = Request::route()->parameters;
    $user = Sentry::user((int)$params[0]);

    $form = Formly::make($user);
    $form->form_class = 'form-horizontal';
    $form->auto_token = false;

    $g = [];
    foreach(Sentry::group()->all() as $group => $value){
      $g[$value['id']] = $value['name'];
    }
    return View::make('users.edit', array('user' => $user, 'group' => $g))->with('form', $form);
  }
  public function post_authenticate()
  {
    $email = Input::get('email');
    $password = md5('codeponpon' . Input::get('password'));
    $new_user = Input::get('new_user', 'off');
    
    $input = array(
      'email' => $email,
      'password' => $password,
      'metadata' => array(
        'first_name' => '',
        'last_name'  => '',
      ),
    );
    
    if( $new_user == 'on' ) {
        
        $rules = array(
            'email' => 'required|email|unique:users',
            'password' => 'required'
        );
        
        $validation = Validator::make($input, $rules);
        
        if( $validation->fails() ) {
            return Redirect::to('home')->with_errors($validation);
        }
        try
        {
          // create the user
          $user = Sentry::user()->create($input);
          $user = Sentry::user($user);
          try{
            $user->add_to_group('superuser');
          }
          catch (Sentry\SentryException $e)
          {
            return Redirect::to('home')->with_errors($e->getMessage());
          }

          return Redirect::to('home');
        }
        catch (Sentry\SentryException $e)
        {
          return Redirect::to('home')->with_errors($e->getMessage());
        }
    } else {
    
        $rules = array(
            'email' => 'required|email|exists:users',
            'password' => 'required'
        );
        
        $validation = Validator::make($input, $rules);
        
        if( $validation->fails() ) {
          return Redirect::to('home')->with_errors($validation);
        }
        
        $credentials = array(
            'username' => $email,
            'password' => $password
        );
        // try to log a user in
        try
        {
          // log the user in
          $valid_login = Sentry::login($credentials['username'], $credentials['password'], true);
          if ($valid_login)
          {
            return Redirect::to('dashboard');
          }
          else
          {
            Session::flash('status_error', 'Your email or password is invalid - please try again.');
            return Redirect::to('home');
          }
        }
        catch (Sentry\SentryException $e)
        {
          return Redirect::to('home')->with_errors($validation);
        }
    }
  }
  
  public function get_logout()
  {
    Sentry::logout();
    return Redirect::to('home');
  }

  public function post_new()
  {
    $params           = Input::all();
    // return print_r($params);
    $inputs           = array(
      'email'     => $params["email"],
      'password'  => $params['password'],
      'activated'  => 1,
      'metadata'  => array(
        'student_code'  => $params['metadata_student_code'],
        'first_name'    => $params['metadata_first_name'],
        'last_name'     => $params['metadata_last_name'],
        'address'       => $params['metadata_address'],
        'sex_type'      => $params['metadata_sex_type'],
        'telephone'     => $params['metadata_telephone'],
      ),
    );
    // return print_r($inputs);
    // $rules = array(
    //   'email' => 'required|email|exists:users',
    //   'password' => 'required|confirmed',
    // );
    // $validation = Validator::make($inputs, $rules);
    // if( $validation->fails() ) {
    //   return Redirect::to('users/new')->with_errors($validation);
    // }
    try
    {
      // create the user
      $user = Sentry::user()->register($inputs);
      Sentry::user($user["id"])->add_to_group($params['group']);
    
      return Redirect::to('users/index');
    }
    catch (Sentry\SentryException $e)
    {
      return $e->getMessage();
    }
  }

}