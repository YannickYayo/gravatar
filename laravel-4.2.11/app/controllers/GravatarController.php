<?php
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
class GravatarController extends BaseController {

	// HOMEPAGE
	
	/* affiche la homepage de l'application */
	public function index()
	{
		return View::make('home');
	}
	
	//PAGE DE CONNEXION
	
	/* Retourne la page permettant de se connecter */
	public function viewLogin(){
		return View::make('login'); 
	}
	
	public function login(){
		
		/* Fonction qui connecte l'utilisateur grace au systeme d'authentification de Laravel */ 
		$datas = array( // on recupère les paramètres du formulaire
            'username' => Input::get('login'),
			'password'=> Input::get('pwd')
		);
		
        if (Auth::attempt($datas)) //on verifie si l'utilisateur existe bien
        {
        	$avatars = $this->listAvatar($datas['username']);	
        	return Redirect::route('avatarlist'); // on va a l'accueil une fois connecter
        }	
        else{
            return Redirect::route('login')->withErrors('Login/mdp invalide'); //sinon on renvois le formulaire
        }
	}
	
	// ACCUEIL AVATAR
	private function listAvatar($login){ // fonction qui retourne la liste des avatars rataché au login passé en paramètre
	
		$email = Auth::user()->email; // on prend l'email de la personne connecter
		$avatars = User_image::where('email','=',$email)->get(); //on fait la requete
		return $avatars; //on retourne le tableau d'avatar
	
	}
	//GESTION DES AVATARS
	
	
	//LIST AVATAR
	public function avatarListView(){ // affiche la vue de gestion des avatars
		$login = Auth::user()->login; //on recupère le login 
		$avatars = $this->listAvatar($login); //on prepare la liste des avatars	
		return View::make('avatarlist')->with(array('avatars'=> $avatars,'login'=>$login)); //on affiche la vue avec en paramètre le login et la liste des avatars
	}
	// ADD AVATAR
	public function addAvatar(){ //formulaire d'ajout d'avatar			
		return View::make('addAvatarForm');	
	}
	
	public function uploadAvatar(){ //upload l'image dans le dosier public/avatars et enregistre la correspondance avec l'utilisateur en bd
		
		$file = Input::file('image'); //on recupère l'image du formulaire
		$destinationPath = public_path().'/avatars/'; //on definit le repertoire qui va les recevoir
		$filename = str_random(10).'_'.$file->getClientOriginalName();//Random name pour eviter les meme noms
		$file->move($destinationPath,$filename); //on deplace l'avatar dans le dossier prévu a cet effet
		$email = Auth::user()->email; //on recupère l'email 
		
		$user_image = new User_image; //on creer un objet 
 		$user_image->email = $email; //on lui affecte l'email
		$user_image->image = $filename; // et l'image recupérer
		$user_image->save(); // on l'enregistre en bd

		return Redirect::route('avatarlist'); //on reafiche la liste
		
	}
	//DELETE AVATAR 
	public function deleteAvatar($id){ //supprime la correspondance en bd et l'image dans le dossier public avec en paramètre l'id de l'avatar
		$user_image = User_image::find($id); //on cherche le bon enregistrement 
		
		$mail = $user_image['email']; //on recupère le mail
		$image = $user_image['image']; // et l'image 
		
		$login = Auth::user()->username; // on recupère le ogin de l'utilisateur
		
		$filename = public_path().'/avatars/'.$image; //on recupère le chemin de l'image
		File::delete($filename); //on supprime l'image du dossier public 
		
		$user_image->delete(); //on supprime la correspondance
 		return Redirect::route('avatarlist'); //on affiche la nouvelle liste d'avatar		
	}
	
	// AJOUT D'UN UTILISATEUR 
	
	public function newUser(){ //formulaire d'ajout de d'utilisateur
		return View::make('userForm') ;
	}
	
	public function createUser(){ //enregistre l'utisateur en bd
		$form = Input::all(); //on recupère les données du formulaire
	
		// on valide les données du formulaire 
		$validator = Validator::make(
				Input::all(),
				array(
						'login'	=> 'required|min:4|unique:users,username',  //login oblgatoire, minimum 4lettres,unique en bd
						'pwd'	=> 'required', //champ obligatoire
						'pwd2' => 'required', //champ obligatoire
						'email' => 'required|email|unique:users,email' //obligatoire, de type email et unique 
				)
		);
		
		if($validator->passes()){ //si c'est validé
			if($form['pwd'] == $form['pwd2']){
				
				$user = new User; //on creer un nouvel utilisateur
				$user->username = $form['login'];
				$user->password = Hash::make($form['pwd']);//on hashe le mot de passe pour des question de securité
				$user->email = $form['email']; 
				$user->save();//on enregistre
				
				return View::make('createUserSuccess')->with(array('login'=>Input::get('login'))); // on affiche la vue de succes 
			}
		}
		else{
			// on retourne les erreurs
			return Redirect::route('newUser')->withInput()->withErrors($validator); //on retourne le formulaire avec les messages d'erreurs
		}
	}
	
	//DECONNEXION
	public function logout(){ //deconnexion de l'utilisateur
		
		Auth::logout(); //on se deconnecte
		return Redirect::to('/');//on retourne a l'accueil		
	}

}
