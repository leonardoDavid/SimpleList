<?php
class AuthController extends BaseController {

    /*
    |--------------------------------------------------------------------------
    | Metodos de Login/Logout
    |--------------------------------------------------------------------------
    |
    | Estas son funciones que responden a metodos de las rutas en relaxcion 
    | a todo lo qu tiene que ver con autentificacion.
    |
    */
    public function showLogin(){
        if (Auth::check()){
            return Redirect::to('/');
        }
        return View::make('login');
    }

    public function postLogin(){
        $loginWithUser = array(
            'username' => Input::get('username'),
            'password' => Input::get('password'),
            'active'   => '1'
        );
        if(Auth::attempt( $loginWithUser , Input::get('remember', 0) )){
            return Redirect::to('/');
        }
        // Retornar con withInput() para retornar el valor de los inputs
        return Redirect::to('login')
            ->with('error_login', 'Tus datos son incorrectos o estas deshabilitado');
    }

    public function logOut()
    {
        Auth::logout();
        return Redirect::to('login')
            ->with('info_login', 'Tu sesión ha sido cerrada.');
    }
}
