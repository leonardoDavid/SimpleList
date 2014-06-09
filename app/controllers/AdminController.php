<?php
class AdminController extends BaseController {

    /*
    |--------------------------------------------------------------------------
    | Metodos de Administracion
    |--------------------------------------------------------------------------
    |
    | Estas son funciones que responden a metodos de las rutas en relaxcion 
    | a todo lo que tiene que ver con la administracion del sistema, como por
    | ejemplo agregar empleados, eliminar, centros de costos, jefaturas, etc.
    |
    */
    public function getEmpleados(){
        $user = Util::getUserData(Auth::user()->id);

        return View::make('admin.empleados',array(
            'titlePage' => "Administración",
            'description' => "Empleados",
            'route' => Util::getTracert(),
            'user' => Util::getUserNotification($user),
            'menu' => Util::getMenu($user['name'],$user['img'])
        ));
    }

}
