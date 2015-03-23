<?php
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
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
		
		$_SESSION['login'] = $datas['username'];
		
        if (Auth::attempt($datas))
        {
        	$avatars = $this->listAvatar($datas['username']);	
        	return Redirect::route('avatarlist');
         
        }	
        else{
            return Redirect::route('login')->withErrors('Login/mdp invalide');
        }
	}
	
	// ACCUEIL AVATAR
	private function listAvatar($login){
	
		$email = Auth::user()->email;
		$avatars = User_image::where('email','=',$email)->get();
		return $avatars;
	
	}
	//GESTION DES AVATARS
	
	
	//LIST AVATAR
	public function avatarListView(){
		$login = Auth::user()->login;
		$avatars = $this->listAvatar($login);	
		return View::make('avatarlist')->with(array('avatars'=> $avatars,'login'=>$login));
	}
	// ADD AVATAR
	public function addAvatar(){			
		return View::make('addAvatarForm');	
	}
	
	public function uploadAvatar(){
		
		$file = Input::file('image');
		$destinationPath = public_path().'/avatars/';
		$filename = str_random(10).'_'.$file->getClientOriginalName();//Random name pour eviter les meme noms
		$file->move($destinationPath,$filename);
		$email = Auth::user()->email;
		
		$user_image = new User_image;
		$user_image->email = $email;
		$user_image->image = $filename;
		$user_image->save();

		return Redirect::route('avatarlist');
		
	}
	//DELETE AVATAR 
	public function deleteAvatar($id){
		$user_image = User_image::find($id);
		
		$mail = $user_image['email'];
		$image = $user_image['image'];
		
		$user = User::where('email','=',$mail)->first();
		$login = $user['username'];
		
		$filename = public_path().'/avatars/'.$image;
		File::delete($filename);
		
		$user_image->delete();
		$avatars = $this->listAvatar($login);
		
		
		return Redirect::route('avatarlist');
		
	}
	
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
