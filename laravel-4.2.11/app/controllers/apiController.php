<?php
/**
 * Created by PhpStorm.
 * User: Yannick
 * Date: 23/03/2015
 * Time: 10:30
 */

class ApiController extends BaseController  {

    public function getConfig(){
        return Response::json(Config::get(api)
        )->setCallback(Input::get('callback'));
    }

}