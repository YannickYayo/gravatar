<?php
/**
 * Created by PhpStorm.
 * User: Yannick
 * Date: 23/03/2015
 * Time: 10:30
 */

class ApiController extends BaseController  {

    public function getConfig(){

        return Response::json(array('version' => Config::get('api.version'),
                'taillesAvatar' => Config::get('api.taillesAvatar'),
                'tailleAvatarDefaut' => Config::get('api.tailleAvatarDefaut'),
                'formatsSupportes' => Config::get('api.formatsSupportes')
            )
        )->setCallback(Input::get('callback'));
    }

    public function getAvatar($email_md5, $size){


        // on sélectionne dans la base les tuples correspondants à l'adresse email
        $user_images = User_image::where('email_md5', '=', $email_md5)->where('image', 'like', '%'.$size.'%')->get();

        // on parcours les tuples pour récupéré le nom des images
        $arraySrc = array();
        foreach($user_images as $user_image){
            $imgName = $user_image['image'];
            $email = $user_image['email'];
            // dans notre tableau on y met les sources des images
            $src = 'http://gravatar/avatars/'.$email.'/'.$imgName;
            array_push($arraySrc, $src);
        }
        return Response::json($arraySrc)->setCallback(Input::get('callback'));

        // output
        return $response;

    }

}