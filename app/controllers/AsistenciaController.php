<?php

use SimpleList\Repositories\JefaturaRepo;
use SimpleList\Repositories\CentroRepo;
use SimpleList\Repositories\EmpleadoRepo;

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

        //Si no despliega la lista solicitada
        $user = JefaturaRepo::getUserData(Auth::user()->id);
        $center = CentroRepo::find(Input::get('centro'));
        $listEmployes = EmpleadoRepo::getTableListEmployes(Input::get('centro'),$center->nombre);

        return View::make('asistencia.take',array(
            'titlePage' => "Asistencia",
            'description' => "Control Diario",
            'user' => JefaturaRepo::getUserNotification($user),
            'route' => Util::getTracert(),
            'menu' => Util::getMenu($user['name'],$user['img']),
            'centers' => CentroRepo::getSelectCenters(Input::get('centro')),
            'list' => $listEmployes,
            'dateSelected' => Input::get('dateList'),
            'disabled' => "disabled"
        ));
    }

}