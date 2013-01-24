<?php

class Chemicals_Controller extends Base_Controller {
	var $layout = "layouts.application";
	public static $per_page = 10;
	public $restful = true;

	public function get_index()
	{
		$params = Input::all();
		if(empty($params)){
			$chemicals = Chemical::order_by('created_at', 'desc')->paginate();
		}else{
			if($params['search_by'] == "requesting_chemical"){
				$user = UsersMetadata::where_first_name($params['text_search'])->first();
				if(count($user)>0){
					$requirements = Requirement::where_user_id($user->user_id)->get();
					$chemical_ids = [];
					foreach($requirements as $requirement){
						array_push($chemical_ids, $requirement->chemical_id);
					}
					$chemicals = Chemical::where_in('id', $chemical_ids)->paginate();
				}else{
					$chemicals = Chemical::where_id(0)->paginate();
				}
			}elseif($params['search_by'] == "chemical_name"){
				$chemicals = Chemical::where('name', 'like', '%'.$params['text_search'].'%')->paginate();
				// return print_r($chemicals->results);
			}else{
				$chemicals = Chemical::order_by('created_at', 'desc')->paginate();
			}			
		}
	    $current_user = Sentry::user();
	    return View::make('chemicals.index', array('chemicals' => $chemicals, 'user' => $current_user));
	}
	public function get_new()
	{	
		$chemical = new Chemical();
		$chemical_types = array();
		foreach(ChemicalType::all() as $chemical){
			$chemical_types[$chemical->id] = $chemical->title;
		}
	    $form = Formly::make($chemical);
	    $form->form_class = 'form-horizontal';
	    $form->auto_token = false;

	    return View::make('chemicals.new', array(
	    	'chemical' => $chemical, 
	    	'chemical_types' => $chemical_types,
	    ))->with('form', $form);
	}
	public function post_new()
	{
		$params     = Input::all();
	    $data       = array();
	    $inputs      = array(
	      'name'    => $params["name"],
	      'sum'  	=> (int)$params['sum']*1000,
	      'mfd' 	=> $params['mfd'],
	      'exp'  	=> $params['exp'],
	    );
	    $rules = array(
	      'name' 	=> 'required',
	      'sum'  	=> 'required',
	      'mfd' 	=> 'required',
	      'exp'  	=> 'required', 
	    );
	    $validation = Validator::make($inputs, $rules);

	    if ($validation->fails()) {
	        return Redirect::to('/chemicals/new')->with_input()->with_errors($validation);
	    }
	    try
	    {
	      $chemical = new Chemical($inputs);
	      if($chemical->save())
	      {
	      	$chemical_type = new ChemicalsChemicalType(array('chemical_type_id'=>$params['chemical_types']));
	      	$chemical->chemicals_chemical_type()->insert($chemical_type);
	      }else{
	        $data['errors'] = 'Cannot save please check again.';
	      }
	    }
	    catch (Sentry\SentryException $e)
	    {
	        $data['errors'] = $e->getMessage();
	    }
	    if (array_key_exists('errors', $data))
	    {
	        return Redirect::to('chemicals/new')->with_input()->with('status_error', $data['errors']);
	    }
	    else
	    {
	      return Redirect::to('chemicals/index');
	    }
	}
	public function post_addtype()
	{
		$input = Input::all();
		$type = new ChemicalType();
		$type->title = $input['name'];
		if($type->save()){
			return Redirect::to('/chemicals/new');
		}
	}
	public function get_destroy()
	{
		$data = array();
		$id = (int)Request::route()->parameters[0];
	    try
	    {
	      // update the user
	      $chemical = Chemical::find($id);
	      $chemical->chemicals_chemical_type()->delete();
	      if (!$chemical->delete())
	      {
	         $data['errors'] = 'Fail!!!, Cannot delete.';
	      }
	    }
	    catch (Sentry\SentryException $e)
	    {
	      $data['errors'] = $e->getMessage();
	    }
	    if (array_key_exists('errors', $data))
	    {
	        return Redirect::to('chemicals/index')->with_input()->with('status_error', $data['errors']);
	    }
	    else
	    {
	      $data['success'] = 'Delete successfull.';
	      return Redirect::to('chemicals/index')->with('status_success', $data['success']);
	    }
	}
	public function get_edit()
	{
		$params = Request::route()->parameters;
	    $chemical = Chemical::find((int)$params[0]);
	    $chemical_types = array();
		foreach(ChemicalType::all() as $chemical_type){
			$chemical_types[$chemical_type->id] = $chemical_type->title;
		}
	    $form = Formly::make($chemical);
	    $form->form_class = 'form-horizontal';
	    $form->auto_token = false;

	    return View::make('chemicals.edit', array(
	    	'chemical' => $chemical, 
	    	'chemical_types' => $chemical_types
	    ))->with('form', $form);
	}
	public function post_edit()
	{
		$data         = array();
	    $id           = (int)Request::route()->parameters[0];
	    $params       = Input::all();
	    $inputs      = array(
	      'name'    => $params["name"],
	      'sum'  	=> $params['sum'],
	      'mfd' 	=> $params['mfd'],
	      'exp'  	=> $params['exp'],
	    );
	    $rules = array(
	      'name' 	=> 'required',
	      'sum'  	=> 'required',
	      'mfd' 	=> 'required',
	      'exp'  	=> 'required', 
	    );
	    $validation = Validator::make($inputs, $rules);

	    if ($validation->fails()) {
	        return Redirect::to('/chemicals/new')->with_input()->with_errors($validation);
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
	      $chemical = Chemical::find($id);
	      $chemical->name 	= $inputs['name'];
	      $chemical->sum 	= $inputs['sum'];
	      $chemical->mfd 	= $inputs['mfd'];
	      $chemical->exp 	= $inputs['exp'];

	      // return print_r($inputs);
	      if ($chemical->save()){
	      	$chemical_type = ChemicalsChemicalType::find($chemical->chemicals_chemical_type()->first()->id);
	      	$chemical_type->chemical_type_id = $params['chemical_types'];
	      	$chemical_type->save();
	      }else{
	      	$data['errors'] = 'Update Fail!!!.';
	      }
	      
	    }
	    catch (Sentry\SentryException $e)
	    {
	      $data['errors']  = $e->getMessage(); // catch errors such as chemical not existing or bad fields
	    }
	    if (array_key_exists('errors', $data))
	    {
	        return Redirect::to('chemicals/edit')->with_input()->with('status_error', $data['errors']);
	    }
	    else
	    {
	      $data['success'] = 'Update successfull.';
	      return Redirect::to('chemicals/index')->with_input()->with('status_success', $data['success']);
	    }
	}

	public function get_search_by_name()
	{
		$chemicals = Chemical::all();
		$name = [];
		foreach($chemicals as $chemical){
			if(!empty($chemical->name)) $name[$chemical->id] = $chemical->name;
		}
		return Response::json($name, 200);	
	}

	public function get_info()
	{
		$id = (int)Request::route()->parameters[0];
		$chemical = Chemical::find($id);
		return Response::json($chemical, 200);		
	}
}
