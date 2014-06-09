<?php
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
        $user = Util::getUserData(Auth::user()->id);

        return View::make('profile.profile',array(
            'titlePage' => "Mi Perfil",
            'description' => "",
            'route' => Util::getTracert(),
            'user' => Util::getUserNotification($user),
            'menu' => Util::getMenu($user['name'],$user['img'])
        ));
    }

}
