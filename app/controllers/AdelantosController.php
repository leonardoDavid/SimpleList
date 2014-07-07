<?php

use SimpleList\Repositories\JefaturaRepo;
use SimpleList\Repositories\CentroRepo;
use SimpleList\Repositories\EmpleadoRepo;
use SimpleList\Managers\AdelantosManager;
use SimpleList\Libraries\Util;

class AdelantosController extends BaseController {
    /*
    |--------------------------------------------------------------------------
    | Metodos de Adelantos
    |--------------------------------------------------------------------------
    |
    | Estas son funciones que responden a metodos de las rutas en relaxcion 
    | a todo lo qu tiene que ver con la parte de ingresar adelantos y los
    | reportes a partir de los filtros entregados
    |
    */
    public function getAddPay(){
        $user = JefaturaRepo::getUserData(Auth::user()->id);

        return View::make('adelantos.doPay',array(
            'titlePage' => "Adelantos",
            'description' => "Ingreso de Adelantos",
            'user' => JefaturaRepo::getUserNotification($user),
            'route' => Util::getTracert(),
            'menu' => Util::getMenu($user['name'],$user['img']),
            'users' => EmpleadoRepo::getSelectEmployes()
        ));
    }

    public function AddPay(){
        $validations = Validator::make(
            array(
                'user' => Input::get('user'),
                'fecha' => Input::get('datePay'),
                'monto' => Input::get('monto',null)
            ),
            array(
                'user' => 'required|exists:empleado,id',
                'fecha' => 'before_today',
                'monto' => 'numeric|min:1|max:99999999999'
            )
        );

        //Se redirecciona en caso de que se tengan errores
        if($validations->fails()){
            $errores = $validations->messages()->all();
            $mensajes = "";
            foreach ($errores as $row){
                $mensajes .= "<li>".$row."</li>";
            }
            return Redirect::to('/adelantos/ingresar')->with('validations-error',$mensajes);
        }

        $fecha = (Input::get('datePay') != "") ? Input::get('datePay') : null;
        if(AdelantosManager::AddPay($fecha))
            return Redirect::to('/adelantos/ingresar')->with('success-system','Adelanto agregado');
        else
            return Redirect::to('/adelantos/ingresar')->with('validations-error','Error al tratar de guardar el adelanto');
    }

}
