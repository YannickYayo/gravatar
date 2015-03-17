<?php
class GravatarController extends BaseController {

	// HOMEPAGE
	
	public function index()
	{
		return View::make('home');
	}
	
	//PAGE DE CONNEXION
	
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
        	$avatars = $this->listAvatar($datas['username']);	
        	return View::make('avatarlist')->with(array('login'=>$datas['username'],'avatars'=> $avatars));
         
        }	
        else{
            return Redirect::route('login')->withErrors('Login/mdp invalide');
        }
	}
	
	// ACCUEIL AVATAR
	public function listAvatar($login){
	
		//on cherche le mail rataché a l'utilisateur
		$user = User::where('username','=',$login)->first();
		$email = $user['email'];
		$avatars = User_image::where('email','=',$email)->get();
		return $avatars;
	
	}
	//GESTION DES AVATARS
	
	
	// AJOUT D'UN UTILISATEUR 
	
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
	
	//DECONNEXION
	public function logout(){
		Auth::logout();
		return Redirect::to('/');
	}

}
