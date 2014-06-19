<?php

use SimpleList\Repositories\JefaturaRepo;
use SimpleList\Libraries\Util;

class ProfileController extends BaseController {
    /*
    |--------------------------------------------------------------------------
    | Metodos de Perfil
    |--------------------------------------------------------------------------
    |
    | Estas son funciones que responden a metodos de las rutas en relaxcion 
    | a todo lo qu tiene que ver con el perfil del usuario, como obtener la info
    | actualizar, cambiar pass, etc.
    |
    */
    public function getProfile(){
        $user = JefaturaRepo::getUserData(Auth::user()->id);

        return View::make('profile.profile',array(
            'titlePage' => "Mi Perfil",
            'description' => "",
            'user' => JefaturaRepo::getUserNotification($user),
            'route' => Util::getTracert(),
            'menu' => Util::getMenu($user['name'],$user['img'])
        ));
    }

}
