<?php

class Repairs_Controller extends Base_Controller {

	public function action_index()
	{	$user = Sentry::user();
		if($user->in_group('student')){
			$repairs = User::find($user->id)->repairs()->order_by('created_at', 'desc')->paginate();
		}elseif($user->in_group('teacher')){
			$repairs = User::find($user->id)->repairs()->order_by('created_at', 'desc')->paginate();
		}else{
			$repairs = Repair::order_by('created_at', 'desc')->paginate();
			if(!Sentry::user()->in_group('superuser')) return Redirect::to('/dashboard')->with('status_error', $message);
		}
		$repair_status = ["pending", "checking", "fixed"];
		$message = "You don't have permission.";
		return View::make('repairs/index', array('repairs'=>$repairs, 'repair_status'=> $repair_status));
	}

	public function action_create()
	{
		$params = Input::all();
		$inputs = array(
			'title'		=> $params['title'],
			'repair_id'	=> $params['repair_id'],
		);
		$repair = StatusRepair::where_repair_id((int)$params['repair_id'])->first();
		if(empty($repair)){
			$repair = new StatusRepair($inputs);
			return !$repair->save() ? Response::json($params, 500) : Response::json('Create successfull', 200);
		}else{
			$repair->title = $params['title'];
			return !$repair->save() ? Response::json($params, 500) : Response::json('Create successfull', 200);
		}
	}

	public function action_destroy()
	{
		$params = Request::route()->parameters;		
		$id 	= (int)$params[0];
		$repair = Repair::find($id);
		if($repair->status_repair()->delete()){
			if($repair->delete()){
				$message = 'Delete successfull.';
				return Redirect::to('/repairs')->with('status_success', $message);
			}
		}else{
			$message = 'Delete fail.';
			return Redirect::to('/repairs')->with('status_error', $message);
		}
	}

}