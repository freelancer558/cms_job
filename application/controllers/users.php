<?php

class Users_Controller extends Base_Controller
{
  var $layout = "layouts.application";
  public $restful = true;
  public function get_index()
  {
    $users = User::all();
    $current_user = Sentry::user();
    $has_access = $current_user->has_access($current_user->groups()[0]['name']);
    return View::make('users.index', array('users' => $users, 'current_user' => $current_user, 'has_access' => $has_access));
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

  public function post_edit()
  {
    $data         = array();
    $id           = (int)Request::route()->parameters[0];
    $params       = Input::all();
    $inputs       = array(
      'password'  => $params['password'],
      'password_confirmation' => $params['password_confirmation'],
      'metadata'  => array(
        'student_code'  => $params['metadata_student_code'],
        'first_name'    => $params['metadata_first_name'],
        'last_name'     => $params['metadata_last_name'],
        'address'       => $params['metadata_address'],
        'sex_type'      => $params['metadata_sex_type'],
        'telephone'     => $params['metadata_telephone'],
      ),
    );

    foreach($inputs as $key => $value){
      if(is_array($value)){
        foreach($value as $meta_key => $meta_value){
          if(empty($value[$meta_key])) unset($value[$meta_key]);
        }
      }else{
        if(empty($inputs[$key])){
          unset($inputs[$key]);
        }
      }
    }
    // print_r($inputs);
    
    try
    {
      // update the user
      $user = Sentry::user($id);
      $update = $user->update($inputs);
      if (!$update)
      {
        $data['errors'] = 'Update fail, Please check you information.';
      }
    }
    catch (Sentry\SentryException $e)
    {
      $data['errors']  = $e->getMessage(); // catch errors such as user not existing or bad fields
    }
    if (array_key_exists('errors', $data))
    {
        return Redirect::to('users/edit')->with_input()->with('status_error', $data['errors']);
    }
    else
    {
      $data['success'] = 'Update successfull.';
      return Redirect::to('users/index')->with_input()->with('status_success', $data['success']);
    }
  }

  public function post_authenticate()
  {
    $email = Input::get('email');
    $password = Input::get('password');
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
          //$user = Sentry::user($user);
          if($user){
            // check if group exists
            if (Sentry::group_exists('superuser')) // or Sentry::group_exists(3)
            {
              Sentry::user($user)->add_to_group('superuser');
            }
            else
            {
              $permissions = array(
                'can_edit'    => 1,
                'can_update'  => 1,
                'can_delete'  => 1,
                'can_add'     => 1,
                'can_manage'  => 1,
              );
              $group    = Sentry::group();
              $group_id = $group->create(array('name'  => 'superuser'));
              $update_group = Sentry::group('superuser')->update_permissions($permissions);
              Sentry::user($user)->add_to_group('superuser');
            }
            
            return Redirect::to('home')->with('status_success', 'Signup Success.');
          }
        }
        catch (Sentry\SentryException $e)
        {
          return Redirect::to('home')->with_input()->with('status_error', $e->getMessage());
        }
    } else {
    
        $rules = array(
            'email' => 'required|email|exists:users',
            'password' => 'required',
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
          $valid_login = Sentry::login($credentials['username'], $credentials['password']);
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
          return Redirect::to('home')->with('status_error', $e->getMessage());
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
    $params       = Input::all();
    $data         = array();
    // return print_r($params);
    $inputs       = array(
      'email'     => $params["email"],
      'password'  => $params['password'],
      'password_confirmation' => $params['password_confirmation'],
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
    $rules = array(
      'email' => 'required|email',
      'password' => 'required|confirmed',
      'password_confirmation' => 'required',
    );
    $validation = Validator::make($inputs, $rules);

    if ($validation->fails()) {
        return Redirect::to('users/new')->with_input()->with_errors($validation);
    }
    try
    {
      unset($inputs["password_confirmation"]);
      $user = Sentry::user()->create($inputs);

      if(!$user)
      {
        $data['errors'] = 'There was an issue when add user to database';
      }
    }
    catch (Sentry\SentryException $e)
    {
        $data['errors'] = $e->getMessage();
    }
    if (array_key_exists('errors', $data))
    {
        return Redirect::to('users/new')->with_input()->with('status_error', $data['errors']);
    }
    else
    {
      Sentry::user($user)->add_to_group($params['group']);
      return Redirect::to('users/index');
    }

  }

  public function get_destroy()
  {
    $id = (int)Request::route()->parameters[0];
    try
    {
      // update the user
      $delete = Sentry::user($id)->delete();
      if ($delete)
      {
          return Redirect::to('users/index');
      }
    }
    catch (Sentry\SentryException $e)
    {
      $data['errors'] = $e->getMessage();
    }
    if (array_key_exists('errors', $data))
    {
        return Redirect::to('users/index')->with_input()->with('status_error', $data['errors']);
    }
    else
    {
      $data['success'] = 'Delete successfull.';
      return Redirect::to('users/index')->with_input()->with('status_success', $data['success']);
    }
  }
}