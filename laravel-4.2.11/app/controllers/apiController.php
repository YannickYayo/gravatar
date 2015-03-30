<?php
/**
 * Created by PhpStorm.
 * User: Yannick
 * Date: 23/03/2015
 * Time: 10:30
 */

class ApiController extends BaseController  {

    public function getConfig(){
        /*
        return Response::json(Config::get(api)
        )->setCallback(Input::get('callback'));
        */
        $response = Response::json(Config::get(api));
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    public function getAvatar($email){

        $img = Image::make('/avatars/yannick.leone@gmail.com/L4a7WLsjn6_300x300_62_800.jpg');

        // create response and add encoded image data
        $response = Response::make($img->encode('png'));

        // set content-type
        $response->header('Content-Type', 'image/png');

        // output
        return $response;

    }

}