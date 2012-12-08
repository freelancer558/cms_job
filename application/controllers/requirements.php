<?php

class Requirements_Controller extends Base_Controller {
	public $restful = true;

	public function get_index()
	{
		$chemicals = Chemical::all();
		$requisitions = Requirement::order_by('created_at', 'desc')->paginate();
		$current_user = Sentry::user();
		$status_requirements = ["pending", "approved", "rejected"];
		return View::make('requirements.requisition', array(
			'chemicals' 	=> $chemicals,
			'requisitions' 	=> $requisitions,
			'current_user' 	=> $current_user,
			'status_requirements' => $status_requirements,
		));
	}

	public function post_requisition()
	{	
		$data = array();
		$params = Input::all();
		$inputs = array(
			'total'			=> $params['total'],
			'user_id' 		=> Sentry::user()->id,
			'chemical_id' 	=> $params['chemical_id'],
		);
		$rules = array(
	      'total' 		=> 'required',
	      'user_id'  	=> 'required',
	      'chemical_id'	=> 'required',
	    );
	    $validation = Validator::make($inputs, $rules);

	    if ($validation->fails()) {
	        return Redirect::to('/requirements')->with_input()->with_errors($validation);
	    }
	    try
	    {
	      	$requisition = new Requirement($inputs);
			if(!$requisition->save()){
				$data['errors'] = 'Cannot save please check again.';
			}else{
				$chemical = Chemical::find($params['chemical_id']);
				$chemical->sum -= $params['total'];
				$chemical->save();

				$sr = new StatusRequirement(array('name' => 'pending'));
				if(!$requisition->status_requirement()->insert($sr)){
					$data['errors'] = 'Cannot save please check again.';	
				}
			}
	    }
	    catch (Sentry\SentryException $e)
	    {
	        $data['errors'] = $e->getMessage();
	    }
	    if (array_key_exists('errors', $data))
	    {
	        return Redirect::to('/requirements')->with_input()->with('status_error', $data['errors']);
	    }
	    else
	    {
	      return Redirect::to('/requirements');
	    }
	}

	public function get_destroy()
	{
		$data = array();
		$id = (int)Request::route()->parameters[0];
	    try
	    {
	      $requisition = Requirement::find($id);
	      $chemical = Chemical::find($requisition->chemical_id);
	      $chemical->sum += $requisition->total;
	      if (!$chemical->save())
	      {
	         $data['errors'] = 'Fail!!!, Cannot delete.';
	      }else{
	      	$requisition->delete();
	      }
	    }
	    catch (Sentry\SentryException $e)
	    {
	      $data['errors'] = $e->getMessage();
	    }
	    if (array_key_exists('errors', $data))
	    {
	        return Redirect::to('/requirements')->with_input()->with('status_error', $data['errors']);
	    }
	    else
	    {
	      $data['success'] = 'Delete successfull.';
	      return Redirect::to('/requirements')->with('status_success', $data['success']);
	    }
	}

	public function post_update_status()
	{
		$params = Input::all();
		$status_requirement = StatusRequirement::find((int)$params['id']);		
		$status_requirement->name = $params['title'];
		return !$status_requirement->save() ? Response::json($params, 500) : Response::json('Change status successfull', 200);
	}
}