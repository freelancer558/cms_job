<?php

class Repairs_Controller extends Base_Controller {

	public function action_index()
	{	
		$params = Input::all();
		$user = Sentry::user();
		$message = "You don't have permission.";
		if($user->in_group('student')){
			$repair_status = ["pending", "reject", "checking", "fixed"];
			$repairs = User::find($user->id)->repairs()->order_by('created_at', 'desc')->paginate();
		}elseif($user->in_group('teacher')){
			$repair_status = ["pending", "reject", "accept"];
			if(empty($params) || empty($params['text_search'])){
				$repairs = Repair::order_by('created_at', 'desc')->paginate();
			}else{
				if($params['search_by'] == "serial_no"){
					$product = Product::where_serial_no($params['text_search'])->first();
					if(count($product)>0){
						$repairs = Repair::where_product_id($product->id)->get();
					}else{
						$repairs = Repair::where_id(0)->get();
					}
				}elseif($params['search_by'] == "student_code"){
					$user_data = UsersMetadata::where_student_code($params['text_search'])->first();
					if(count($user_data)>0){
						$repairs = User::find($user_data->user_id)->repairs()->order_by('created_at', 'desc')->get();
					}else{
						$repairs = Repair::where_id(0)->get();	
					}
				}elseif($params['search_by'] == "chemical_status"){
					$repaire_ids = [];
					$status_repair = StatusRepair::where('title', '=', $params['text_search'])->get();
					foreach($status_repair as $repaire) {
						array_push($repaire_ids, $repaire->repair_id);
					}
					$repairs = Repair::where_in('id', $repaire_ids)->get();
				}elseif($params['search_by'] == 'datetime'){
					$repaire_ids = [];
					$status_repair = $status_repair = DB::query('SELECT * FROM `repairs` WHERE created_at BETWEEN DATE_ADD(DATE(?), INTERVAL -1 DAY)   AND  DATE_ADD(DATE(?), INTERVAL 1 DAY)', array($params['start_at'], $params['end_at']));
					if(count($status_repair)>0){
						foreach($status_repair as $repaire) {
							array_push($repaire_ids, $repaire->id);
						}
						$repairs = Repair::where_in('id', $repaire_ids)->get();
					}else{
						$repairs = Repair::where_id(0)->get();	
					}
				}else{
					$repairs = Repair::order_by('created_at', 'desc')->get();
				}
			}
		}else{
			$repair_status = ["pending", "reject", "checking", "fixed"];
			if(empty($params) || empty($params['text_search'])){
				$repairs = Repair::order_by('created_at', 'desc')->paginate();
			}else{
				if($params['search_by'] == "serial_no"){
					$product = Product::where_serial_no($params['text_search'])->first();
					if(count($product)>0){
						$repairs = Repair::where_product_id($product->id)->get();
					}else{
						$repairs = Repair::where_id(0)->get();
					}
				}elseif($params['search_by'] == "student_code"){
					$user_data = UsersMetadata::where_student_code($params['text_search'])->first();
					if(count($user_data)>0){
						$repairs = User::find($user_data->user_id)->repairs()->order_by('created_at', 'desc')->get();
					}else{
						$repairs = Repair::where_id(0)->get();	
					}
				}elseif($params['search_by'] == "chemical_status"){
					$repaire_ids = [];
					$status_repair = StatusRepair::where('title', '=', $params['text_search'])->get();
					foreach($status_repair as $repaire) {
						array_push($repaire_ids, $repaire->repair_id);
					}
					$repairs = Repair::where_in('id', $repaire_ids)->get();
				}elseif($params['search_by'] == 'datetime'){
					$repaire_ids = [];
					$status_repair = $status_repair = DB::query('SELECT * FROM `repairs` WHERE created_at BETWEEN DATE_ADD(DATE(?), INTERVAL -1 DAY)   AND  DATE_ADD(DATE(?), INTERVAL 1 DAY)', array($params['start_at'], $params['end_at']));
					if(count($status_repair)>0){
						foreach($status_repair as $repaire) {
							array_push($repaire_ids, $repaire->id);
						}
						$repairs = Repair::where_in('id', $repaire_ids)->get();
					}else{
						$repairs = Repair::where_id(0)->get();	
					}
				}else{
					$repairs = Repair::order_by('created_at', 'desc')->get();
				}
			}
			if(!Sentry::user()->in_group('superuser')) return Redirect::to('/dashboard')->with('status_error', $message);
		}
		
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
		$status_repair = StatusRepair::where_repair_id((int)$params['repair_id'])->first();
		$repair = Repair::find((int)$params['repair_id']);
		if(empty($status_repair)){
			$status_repair = new StatusRepair($inputs);
			return !$status_repair->save() ? Response::json($params, 500) : Response::json('Change status successfull', 200);
		}else{
			$status_repair->title = $params['title'];
			$repair->fix_cost = $params['fix_cost'];
			$repair->invoice_id = $params['invoice_id'];
			$repair->save();
			return !$status_repair->save() ? Response::json($params, 500) : Response::json('Change status successfull', 200);
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

	public function action_tracking()
	{
		$params = Request::route()->parameters;		
		$id 	= (int)$params[0];
		$repairs = Repair::where_product_id($id)->paginate();
		return View::make('repairs.tracking', array('repairs'=>$repairs));
	}
}