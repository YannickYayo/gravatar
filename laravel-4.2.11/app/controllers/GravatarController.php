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
	
	public function newUser(){
		return View::make('userForm') ;
	}
	
	public function createUser(){
		$form = Input::all();
	
		// on valide les données du formulaire 
		$validator = Validator::make(
				Input::all(),
				array(
						'login'	=> 'required|min:4|unique:users,username',
						'pwd'	=> 'required',
						'pwd2' => 'required',
						'email' => 'required|email|unique:users,email'
				)
		);
		
		if($validator->passes()){
			if($form['pwd'] == $form['pwd2']){
				$user = new User;
				$user->username = $form['login'];
				$user->password = Hash::make($form['pwd']);
				$user->email = $form['email'];
				$user->save();
				return View::make('createUserSuccess')->with(array('login'=>Input::get('login')));
			}
		}
		else{
			// on retourne les erreurs
			return Redirect::route('newUser')->withInput()->withErrors($validator);
		}
	}

}
