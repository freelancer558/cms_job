<?php

class Repairs_Controller extends Base_Controller {

	public function action_index()
	{	$user = Sentry::user();
		if($user->in_group('student')){
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
			if(!$repair) return Response::json($params, 500);
			if($repair) return Response::json('Create successfull', 200);
		}else{
			$repair->title = $params['title'];
			if(!$repair->save()) return Response::json($params, 500);
			if($repair->save()) return Response::json('Update successfull', 200);
		}
	}

}