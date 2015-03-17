<?php
class GravatarController extends BaseController {

	/*
	 |--------------------------------------------------------------------------
	 | Default Home Controller
	 |--------------------------------------------------------------------------
	 |
	 | You may wish to use controllers instead of, or in addition to, Closure
	 | based routes. That's great! Here is an example controller method to
	 | get you started. To route to this controller, just add the route:
	 |
	 |	Route::get('/', 'HomeController@showWelcome');
	 |
	 */

	public function index()
	{
		return View::make('home');
	}
	
	public function viewLogin(){
		return View::make('login'); 
	}
	
	public function login(){
		$datas = array(
            'username' => Input::get('login'),
			'password'=> Input::get('pwd')
		);
		
        if (Auth::attempt($datas))
        {
            return View::make('test') ;
        }	
        else{
            return Redirect::route('login')->withErrors('Login/mdp invalide');
        }
	}

}
