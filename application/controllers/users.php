<?php

class Users_Controller extends Base_Controller
{
  var $layout = "layouts.application";

  public function action_index()
  {
    $users = User::all();
    return View::make('users.index', array('users' => $users));
  }

  public function action_authenticate()
  {
    $email = Input::get('email');
    $password = md5('codeponpon' . Input::get('password'));
    $new_user = Input::get('new_user', 'off');
    
    $input = array(
        'email' => $email,
        'password' => $password
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
        
        try {
            $user = new User();
            $user->email = $email;
            $user->password = Hash::make($password);
            $user->save();
            Auth::login($user);
        
            return Redirect::to('dashboard');
        }  catch( Exception $e ) {
            Session::flash('status_error', 'An error occurred while creating a new account - please try again.');
            return Redirect::to('home');
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
        if( Auth::attempt($credentials)) {
            return Redirect::to('dashboard');
        } else {
            Session::flash('status_error', 'Your email or password is invalid - please try again.');
            return Redirect::to('home');
        }
    }
  }
  
  public function action_logout()
  {
    Auth::logout();
    return Redirect::to('home');
  }

  public function action_create()
  {
      $logged_in_user   = Auth::user();
      $inputs           = Input::all();
      $user             = array(
        "email" => $inputs["email"],
        
      );
      $metadata         = array();
      $photo            = array();
  }
}