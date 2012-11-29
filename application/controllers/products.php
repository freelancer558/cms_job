<?php

class Products_Controller extends Base_Controller
{
	var $layout = "layouts.application";
	public $restful = true;
	public function get_index()
	{
		$products = Product::all();
	    $current_user = Sentry::user();
	    $has_access = $current_user->has_access($current_user->groups()[0]['name']);
	    return View::make('products.index', array('products' => $products, 'current_user' => $current_user, 'has_access' => $has_access));
	}
	public function get_new()
	{
		$product = new Product();

	    $form = Formly::make($product);
	    $form->form_class = 'form-horizontal';
	    $form->auto_token = false;

	    $g = [];
	    foreach(Sentry::group()->all() as $group => $value){
	      $g[$value['id']] = $value['name'];
	    }
	    return View::make('products.new', array('product' => $product, 'group' => $g))->with('form', $form);
	}
	public function post_new()
	  {
	    $params     = Input::all();
	    $data       = array();
	    // return print_r($params);
	    $inputs      = array(
	      'name'    => $params["name"],
	      'sum'  	=> $params['sum'],
	      'data' 	=> $params['data'],
	      'model'  	=> $params['model'],
	      'disburse'=> $params['disburse'],
	    );
	    //return print_r($inputs);
	    $rules = array(
	      'name' 	=> 'required',
	      'sum'  	=> 'required',
	      'data' 	=> 'required',
	      'model'  	=> 'required', 
	      'disburse'=> 'required',
	    );
	    $validation = Validator::make($inputs, $rules);

	    if ($validation->fails()) {
	        return Redirect::to('products/new')->with_input()->with_errors($validation);
	    }
	    try
	    {
	      $product = new Product($inputs);

	      if(!$product->save())
	      {
	        $data['errors'] = 'Cannot save please check again.';
	      }
	    }
	    catch (Sentry\SentryException $e)
	    {
	        $data['errors'] = $e->getMessage();
	    }
	    if (array_key_exists('errors', $data))
	    {
	        return Redirect::to('products/new')->with_input()->with('status_error', $data['errors']);
	    }
	    else
	    {
	      return Redirect::to('products/index');
	    }

	  }
	  public function get_show()
	  {
	    $params = Request::route()->parameters;
	    $product = Product::find((int)$params[0]);
	    // return print_r($product);
	    return View::make('products.show', array('product' => $product));
	  }
	  public function get_edit()
	  {
	    $params = Request::route()->parameters;
	    $product = Product::find((int)$params[0]);

	    $form = Formly::make($product);
	    $form->form_class = 'form-horizontal';
	    $form->auto_token = false;

	    return View::make('products.edit', array('product' => $product))->with('form', $form);
	  }
	  public function post_edit()
	  {
	    $data         = array();
	    $id           = (int)Request::route()->parameters[0];
	    $params       = Input::all();
	    $inputs      = array(
	      'name'    => $params["name"],
	      'sum'  	=> $params['sum'],
	      'data' 	=> $params['data'],
	      'model'  	=> $params['model'],
	      'disburse'=> $params['disburse'],
	    );
	    //return print_r($inputs);
	    $rules = array(
	      'name' 	=> 'required',
	      'sum'  	=> 'required',
	      'data' 	=> 'required',
	      'model'  	=> 'required', 
	      'disburse'=> 'required',
	    );

	    $validation = Validator::make($inputs, $rules);
        
        if( $validation->fails() ) {
            return Redirect::to('products/new')->with_errors($validation);
        }

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
	      $product = Product::find($id);
	      foreach(array_keys($inputs) as $index => $key){
	      	if($key == 'name') $product->name = $inputs["name"];
	      	if($key == 'sum') $product->sum = $inputs["sum"];
	      	if($key == 'data') $product->data = $inputs["data"];
	      	if($key == 'model') $product->model = $inputs["model"];
	      	if($key == 'disburse') $product->disburse = $inputs["disburse"];
	      }
	      // return print_r($inputs);
	      if (!$product->save())
	      {
	        $data['errors'] = 'Update fail, Please check you information.';
	      }
	    }
	    catch (Sentry\SentryException $e)
	    {
	      $data['errors']  = $e->getMessage(); // catch errors such as product not existing or bad fields
	    }
	    if (array_key_exists('errors', $data))
	    {
	        return Redirect::to('products/edit')->with_input()->with('status_error', $data['errors']);
	    }
	    else
	    {
	      $data['success'] = 'Update successfull.';
	      return Redirect::to('products/index')->with_input()->with('status_success', $data['success']);
	    }
	  }
	   public function get_destroy()
	  {
	    $id = (int)Request::route()->parameters[0];
	    try
	    {
	      // update the user
	      $delete = Product::find($id)->delete();
	      if ($delete)
	      {
	          return Redirect::to('products/index');
	      }
	    }
	    catch (Sentry\SentryException $e)
	    {
	      $data['errors'] = $e->getMessage();
	    }
	    if (array_key_exists('errors', $data))
	    {
	        return Redirect::to('products/index')->with_input()->with('status_error', $data['errors']);
	    }
	    else
	    {
	      $data['success'] = 'Delete successfull.';
	      return Redirect::to('products/index')->with('status_success', $data['success']);
	    }
	  }
}