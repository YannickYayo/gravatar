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
		$datas = array( // on recupere les parametres du formulaire
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
	private function listAvatar($login){ // fonction qui retourne la liste des avatars ratache au login passe en parametre
	
		$email = Auth::user()->email; // on prend l'email de la personne connecter
		$avatars = User_image::where('email','=',$email)->get(); //on fait la requete
		return $avatars; //on retourne le tableau d'avatar
	
	}
	//GESTION DES AVATARS
	
	
	//LIST AVATAR
	public function avatarListView(){ // affiche la vue de gestion des avatars
		$login = Auth::user()->username; //on recupere le login 
		$avatars = $this->listAvatar($login); //on prepare la liste des avatars	
		return View::make('avatarlist')->with(array('avatars'=> $avatars,'login'=>$login)); //on affiche la vue avec en parametre le login et la liste des avatars
	}
	// ADD AVATAR
	public function addAvatar(){ //formulaire d'ajout d'avatar			
		return View::make('addAvatarForm');	
	}
	
	public function uploadAvatar(){ //upload l'image dans le dosier public/avatars et enregistre la correspondance avec l'utilisateur en bd

		$email = Auth::user()->email; //on recupere l'email
		$email_md5 = md5($email);
		$file = Input::file('image'); //on recupere l'image du formulaire
		$destinationPath = public_path().'/avatars/'.$email; //on definit le repertoire qui va les recevoir
		if (!file_exists($destinationPath)) { // on créé le dossier correspondant à l'adresse email si il n'existe pas
			mkdir($destinationPath); // ce dossier contiendra les images
		}
		$randomString = str_random(10);//Random name pour eviter les meme noms

		// on upload l'avatar sous 3 formats (200x200, 300x300 et 400x400)
		$filename = $randomString.'_200x200_'.$file->getClientOriginalName();// on créé le nom du fichier
		Image::make($file)->resize(200, 200)->save($destinationPath.'/'.$filename);//on deplace l'avatar dans le dossier prevu a cet effet
		$user_image = new User_image; //on creer un objet
		$user_image->email = $email; //on lui affecte l'email
		$user_image->email_md5 = $email_md5;
		$user_image->image = $filename; // et l'image recuperer
		$user_image->save(); // on l'enregistre en bd

		$filename = $randomString.'_300x300_'.$file->getClientOriginalName();//Random name pour eviter les meme noms
		Image::make($file)->resize(300, 300)->save($destinationPath.'/'.$filename);//on deplace l'avatar dans le dossier prevu a cet effet
		$user_image = new User_image; //on creer un objet
		$user_image->email = $email; //on lui affecte l'email
		$user_image->email_md5 = $email_md5;
		$user_image->image = $filename; // et l'image recuperer
		$user_image->save(); // on l'enregistre en bd

		$filename = $randomString.'_400x400_'.$file->getClientOriginalName();//Random name pour eviter les meme noms
		Image::make($file)->resize(400, 400)->save($destinationPath.'/'.$filename);//on deplace l'avatar dans le dossier prevu a cet effet
		$user_image = new User_image; //on creer un objet
		$user_image->email = $email; //on lui affecte l'email
		$user_image->email_md5 = $email_md5;
		$user_image->image = $filename; // et l'image recuperer
		$user_image->save(); // on l'enregistre en bd

		return Redirect::route('avatarlist'); //on reaffiche la liste
		
	}
	//DELETE AVATAR 
	public function deleteAvatar($randomString){ //supprime la correspondance en bd et l'image dans le dossier public avec en parametre l'id de l'avatar

		$images = User_image::where('image', 'like', $randomString.'%')->get();

		foreach ($images as $img){
			$mail = $img['email']; //on recupere le mail
			$image = $img['image']; // et l'image
			$filename = public_path().'/avatars/'.$mail.'/'.$image; //on recupere le chemin de l'image
			File::delete($filename); //on supprime l'image du dossier public
		}

		User_image::where('image', 'like', $randomString.'%')->delete(); //on supprime la correspondance
 		return Redirect::route('avatarlist'); //on affiche la nouvelle liste d'avatar
	}
	
	// AJOUT D'UN UTILISATEUR 
	
	public function newUser(){ //formulaire d'ajout de d'utilisateur
		return View::make('userForm') ;
	}
	
	public function createUser(){ //enregistre l'utisateur en bd
		$form = Input::all(); //on recupere les donnees du formulaire
	
		// on valide les donnees du formulaire 
		$validator = Validator::make(
				Input::all(),
				array(
						'login'	=> 'required|min:4|unique:users,username',  //login oblgatoire, minimum 4lettres,unique en bd
						'pwd'	=> 'required', //champ obligatoire
						'pwd2' => 'required|same:pwd', //champ obligatoire et doit correspondre à pwd
						'email' => 'required|email|unique:users,email' //obligatoire, de type email et unique
				)
		);
		
		if($validator->passes()){ //si c'est valide

			$user = new User; //on creer un nouvel utilisateur
			$user->username = $form['login'];
			$user->password = Hash::make($form['pwd']);//on hashe le mot de passe pour des question de securite
			$user->email = $form['email'];
			$user->save();//on enregistre

			return View::make('createUserSuccess')->with(array('login'=>Input::get('login'))); // on affiche la vue de succes

		}
		else{//sinon
			return Redirect::route('newUser')->withInput()->withErrors($validator); //on retourne le formulaire avec les messages d'erreurs
		}
	}
	
	//DECONNEXION
	public function logout(){ //deconnexion de l'utilisateur
		
		Auth::logout(); //on se deconnecte
		return Redirect::to('/');//on retourne a l'accueil 		
	}

}
