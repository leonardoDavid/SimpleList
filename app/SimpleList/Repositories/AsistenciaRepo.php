<?php namespace SimpleList\Repositories;

use SimpleList\Entities\Asistencia;
use SimpleList\Entities\Empleado;
use SimpleList\Repositories\EmpleadoRepo;
use SimpleList\Repositories\JefaturaRepo;
use SimpleList\Repositories\CentroRepo;
use SimpleList\Libraries\Util;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AsistenciaRepo{

	/*
    |--------------------------------------------------------------------------
    | Funciones Comunes
    |--------------------------------------------------------------------------
    |
    | Estas funciones son reutilizables por todos los metodos del controlador
    | que requieran informacion con respecto al modelo de Asistencia
    |
    */
    public static function newList($fecha = null){
        $user = JefaturaRepo::getUserData(Auth::user()->id);
        $center = CentroRepo::find(Input::get('centro'));
        $listEmployes = (!is_null($fecha)) ? EmpleadoRepo::getTableListEmployes(Input::get('centro'),$center->nombre,$fecha) : EmpleadoRepo::getTableListEmployes(Input::get('centro'),$center->nombre);

        return View::make('asistencia.take',array(
            'titlePage' => "Asistencia",
            'description' => "Control Diario",
            'user' => JefaturaRepo::getUserNotification($user),
            'route' => Util::getTracert(),
            'menu' => Util::getMenu($user['name'],$user['img']),
            'centers' => CentroRepo::getSelectCenters(Input::get('centro')),
            'list' => $listEmployes,
            'dateSelected' => (Input::get('dateList') == "") ? date("d/m/Y") : Input::get('dateList'),
            'disabled' => "disabled"
        ));            
    }

    public static function updateList($fecha){
        return AsistenciaRepo::newList($fecha);
    }

    public static function existsList($fecha = null){
        if(!empty($fecha)){
            $tmp = explode("/", $fecha);
            $tmp = $tmp[2]."-".$tmp[1]."-".$tmp[0];
            $empleados = Empleado::where('empleado.id','!=',Auth::user()->id_empleado)
                        ->join('asistencia','id_empleado','=','empleado.id')
                        ->where('empleado.centro_costo','=',Input::get('centro'))
                        ->where(DB::raw('DATE(asistencia.created_at)'),'=',$tmp)
                        ->select("empleado.ape_paterno as paterno","empleado.ape_materno as materno","empleado.nombre as firstname","empleado.id as rut",'empleado.active as status','asistencia.comentario as comentario','asistencia.active as presencia')
                        ->count();
            return ($empleados > 0) ? true : false;
        }
        else{
            return false;
        }
    }
}