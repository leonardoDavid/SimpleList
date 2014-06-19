<?php

use SimpleList\Repositories\JefaturaRepo;
use SimpleList\Repositories\CentroRepo;
use SimpleList\Repositories\AsistenciaRepo;
use SimpleList\Libraries\Util;
use SimpleList\Managers\AsistenciaManager;

class AsistenciaController extends BaseController {
    /*
    |--------------------------------------------------------------------------
    | Metodos de Asistencia
    |--------------------------------------------------------------------------
    |
    | Estas son funciones que responden a metodos de las rutas en relaxcion 
    | a todo lo qu tiene que ver con la parte de tomar asistecia o ver/generar
    | reportes a partir de los filtros entregados
    |
    */
    public function getTake(){
        $user = JefaturaRepo::getUserData(Auth::user()->id);

        return View::make('asistencia.take',array(
            'titlePage' => "Asistencia",
            'description' => "Control Diario",
            'user' => JefaturaRepo::getUserNotification($user),
            'route' => Util::getTracert(),
            'menu' => Util::getMenu($user['name'],$user['img']),
            'centers' => CentroRepo::getSelectCenters(),
            'list' => "",
            'dateSelected' => "",
            'disabled' => ""
        ));
    }

    public function getListAssistance(){
        $validations = Validator::make(
            array(
                'centro' => Input::get('centro'),
                'fecha' => Input::get('dateList')
            ),
            array(
                'centro' => 'required|exists:centro_costo,id',
                'fecha' => 'before_today'
            )
        );

        //Se redirecciona en caso de que se tengan errores
        if($validations->fails()){
            $errores = $validations->messages()->all();
            $mensajes = "";
            foreach ($errores as $row){
                $mensajes .= "<li>".$row."</li>";
            }
            return Redirect::to('/asistencia/tomar')->with('validations-error',$mensajes);
        }

        if(AsistenciaRepo::existsList(Input::get('dateList'))){
            return AsistenciaRepo::updateList(Input::get('dateList'));
        }
        else{
            return AsistenciaRepo::newList();
        }
    }

    public function saveAssistance(){
        if(Request::ajax()){
            $response = AsistenciaManager::save();
        }
        else{
            $response = array(
                'status' => false,
                'motivo' => "Error en el tipo de solicitud"
            );
        }

        return json_encode($response);
    }

}
