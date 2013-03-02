<?php

class Chemicals_Controller extends Base_Controller {
	var $layout = "layouts.application";
	public static $per_page = 10;
	public $restful = true;

	public function get_index()
	{
		$params = Input::all();
		if(empty($params['search_by'])){
			$chemicals = Chemical::where('remove', '=', 0)->order_by('created_at', 'desc')->paginate();
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
	public function get_management()
	{
		$params = Input::all();
		if(empty($params['search_by'])){
			$status = StatusRequirement::order_by('created_at', 'desc')->paginate();
		}else{
			$ids = [];
			if($params['search_by'] == "chemical_name" && !empty($params['text_search'])){
				$chemicals = Chemical::where('name', 'LIKE', '%'.$params['text_search'].'%')->paginate();
				if(count($chemicals->results)>0){
					foreach($chemicals->results as $chemical => $result){
						$requirement = Requirement::where_chemical_id($result->id)->first();
						if(count($requirement)>0) array_push($ids, $requirement->id);
					}
					$status = StatusRequirement::where_in('requirement_id', $ids)->paginate();
				}else{
					$status = StatusRequirement::where_id(0)->paginate();
				}
			}elseif($params['search_by'] == "std_code" && !empty($params['text_search'])){
				$users = UsersMetadata::where('student_code', 'LIKE', '%'.$params['text_search'].'%')->paginate();
				if(count($users->results)>0){
					foreach($users->results as $user => $result){
						$requirement = Requirement::where_user_id($result->user_id)->first();
						if(count($requirement)>0) array_push($ids, $requirement->id);
					}
					$status = StatusRequirement::where_in('requirement_id', $ids)->paginate();
				}else{
					$status = StatusRequirement::where_id(0)->paginate();
				}
			}else{
				$status = StatusRequirement::where_id(0)->paginate();
			}
		}
		$current_user = Sentry::user();
		return View::make('chemicals.manage', array(
			'requisitions' 	=> $status,
			'current_user' 	=> $current_user,
		));
	}
	public function post_management()
	{
		$params = Input::all();
		$status_requirement = StatusRequirement::find((int)$params['requisition_id']);
		$status_requirement->name = 'approved';

		$requirement = Requirement::find($status_requirement->requirement_id);		
		$requirement->total = $params['requisition_value'];
		$requirement->save();
		$status_requirement->save();		

		$chemical = Chemical::find((int)$params['chemical_id']);
		$chemical->sum -= $params['requisition_value'];
		$chemical->save();

		return Redirect::to('/chemicals/management');
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
	      'minimum' => $params['minimum'],
	    );
	    $rules = array(
	      'name' 	=> 'required',
	      'sum'  	=> 'required',
	      'mfd' 	=> 'required',
	      'exp'  	=> 'required', 
	      'minimum' => 'required',
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
	public function get_hide_low()
	{
		$data = array();
		$id = (int)Request::route()->parameters[0];
    try
    {
      // update the user
      $chemical = Chemical::find($id);
      $chemical->show_low = 0;
      if (!$chemical->save())
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
        return Redirect::to('/dashboard')->with_input()->with('status_error', $data['errors']);
    }
    else
    {
      $data['success'] = 'Delete successfull.';
      return Redirect::to('/dashboard')->with('status_success', $data['success']);
    }
	}
	public function get_hide()
	{
		$data = array();
		$id = (int)Request::route()->parameters[0];
    try
    {
      // update the user
      $chemical = Chemical::find($id);
      $chemical->show = 0;
      if (!$chemical->save())
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
        return Redirect::to('/dashboard')->with_input()->with('status_error', $data['errors']);
    }
    else
    {
      $data['success'] = 'Delete successfull.';
      return Redirect::to('/dashboard')->with('status_success', $data['success']);
    }
	}
	public function get_remove()
	{
		$data = array();
		$id = (int)Request::route()->parameters[0];
    try
    {
      // update the user
      $chemical = Chemical::find($id);
      $chemical->remove = true;
      if (!$chemical->save())
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
        return Redirect::to('/chemicals')->with_input()->with('status_error', $data['errors']);
    }
    else
    {
      $data['success'] = 'Delete successfull.';
      return Redirect::to('/chemicals')->with('status_success', $data['success']);
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
	      $requirement = Requirement::where_chemical_id($chemical->id)->get();
	      if(!empty($chemical)){
	      	$chemical->chemicals_chemical_type()->delete();
		      if(!empty($requirement)) {
		      	$status_requirement = StatusRequirement::where_requirement_id($requirement->id)->get();
		      	if(!empty($status_requirement)){
		      		$status_requirement->delete();
		      	}
		      	$requirement->delete();
		      }
		      if (!$chemical->delete()) $data['errors'] = 'Fail!!!, Cannot delete.';
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
		$chemicals = Chemical::where('remove', '=', 0)->get();
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
