<?php
class Dashboard_Controller extends Base_Controller
{
    public function action_index()
    {
        // $photos = Auth::user()->photos()->order_by('created_at', 'desc')->order_by('id', 'desc')->get();
        // return View::make('dashboard.index', array('photos' => $photos));
        $chemicals = Chemical::where('exp', '>=', 'DATE_ADD(LAST_DAY(DATE_SUB(NOW(), INTERVAL 1 MONTH)), INTERVAL 1 DAY)', 'AND', 'show', '=', 1)->order_by('exp', 'desc')->paginate();
        // $chemicals = DB::table('chemicals')->where('show', '=', 1)->or_where(function($query){
        //   $query->where('exp', '<', 'NOW()');
        //   $query->where('exp', '>', '(NOW() - INTERVAL 1 MONTH)');
        // })->order_by('exp', 'desc')->paginate();
        // $chemicals = DB::query('SELECT * FROM `chemicals` WHERE `show` = 1 AND `exp` < NOW() OR `exp` > (NOW() - INTERVAL 1 MONTH) ORDER BY exp DESC')->paginate();
        $chemicals_is_low = Chemical::where('show_low', '=', 1)->order_by('sum', 'asc')->paginate();
        $current_user = Sentry::user();
        if(Sentry::check()) return View::make('dashboard.index', array('chemicals' => $chemicals, 'chemicals_is_low' => $chemicals_is_low, 'user' => $current_user));
        return Redirect::to('/users/login')->with('status_error', 'You have to signin before access dashboard.');
    }
    
    public function action_insert_test_data()
    {
        $logged_in_user = Auth::user();
        
        for( $x = 0; $x < 10; $x++ ) {
            $email = rand().'@gmail.com';
            $user = new User();
            $user->email = $email;
            $user->password = Hash::make($email);
            $user->save();
            
            $logged_in_user->followers()->attach($user->id);
            if( $x > 5 ) {
                $logged_in_user->following()->attach($user->id);
            }
        }
        
        $photos = array(
            array(
                'user_id' => $logged_in_user->id,
                'location' => 'http://farm6.staticflickr.com/5044/5319042359_68fb1f91b4.jpg',
                'description' => 'Dusty Memories, The Girl in the Black Beret (http://www.flickr.com/photos/cloudy-day/)'
            ),
            array(
                'user_id' => $logged_in_user->id,
                'location' => 'http://farm3.staticflickr.com/2354/2180198946_a7889e3d5c.jpg',
                'description' => 'Rascals, Tannenberg (http://www.flickr.com/photos/tannenberg/)'
            ),
            array(
                'user_id' => $logged_in_user->id,
                'location' => 'http://farm7.staticflickr.com/6139/5922361568_85628771cd.jpg',
                'description' => 'Sunset, Funset, Nikko Bautista (http://www.flickr.com/photos/nikkobautista/)'
            )
        );
        $logged_in_user->photos()->save($photos);
    }
}