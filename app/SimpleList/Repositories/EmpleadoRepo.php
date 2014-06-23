<?php namespace SimpleList\Repositories;

use SimpleList\Entities\Empleado;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

class EmpleadoRepo{
	
	/*
    |--------------------------------------------------------------------------
    | Funciones Comunes
    |--------------------------------------------------------------------------
    |
    | Estas funciones son reutilizables por todos los metodos del controlador
    | que requieran informacion con respecto al modelo de Empleado
    |
    */

    public static function count(){
        return Empleado::where('active','=','1')->count();
    }

    public static function getEmpleoyesWithoutMe(){
        return Empleado::where('id','!=',Auth::user()->id_empleado)
                        ->select("empleado.ape_paterno as paterno","empleado.ape_materno as materno","empleado.nombre as firstname","empleado.id as rut",'empleado.active as status')
                        ->get();
    }

    public static function getTableListEmployes($idCenter,$centro,$fecha = null){
        if(!is_null($fecha)){
            $tmp = explode("/", $fecha);
            $tmp = $tmp[2]."-".$tmp[1]."-".$tmp[0];
            $employes = Empleado::where('empleado.id','!=',Auth::user()->id_empleado)
                        ->join('asistencia','id_empleado','=','empleado.id')
                        ->where('empleado.centro_costo','=',$idCenter)
                        ->where(DB::raw('DATE(asistencia.created_at)'),'=',$tmp)
                        ->select("empleado.ape_paterno as paterno","empleado.ape_materno as materno","empleado.nombre as firstname","empleado.id as rut",'empleado.active as status','asistencia.comentario as comentario','asistencia.active as presencia')
                        ->get();
            $route = "update";
        }
        else{
            $employes = Empleado::where('id','!=',Auth::user()->id_empleado)
                        ->where('centro_costo','=',$idCenter)
                        ->select("empleado.ape_paterno as paterno","empleado.ape_materno as materno","empleado.nombre as firstname","empleado.id as rut",'empleado.active as status')
                        ->get();
            $route = "save";
            $tmp = "";
        }
        $list = "";
        $values = "[";
        $vuelta = 0;

        foreach ($employes as $employ){
            $estado = ($employ->status == 1) ? 'Activo' : 'Desactivado';
            $values .= ($vuelta > 0) ? "," : "";
            if(!is_null($fecha)){
                $values .= ($employ->presencia == 1) ? "'".str_replace("-","SL",$employ->rut)."ST1'" : "'".str_replace("-","SL",$employ->rut)."ST0'";
                $asistencia = ($employ->presencia == 1) ? " checked='checked' " : '';
            }
            else{
                $values .= "'".str_replace("-","SL",$employ->rut)."ST1'";
                $asistencia = "";
            }
            $checked = (!is_null($fecha)) ? $asistencia : " checked='checked' ";
            $commentary = (!is_null($fecha)) ? $employ->comentario : "";

            $list .= "<tr>";
            $list .= "<td>".$employ->rut."</td>";
            $list .= "<td>".ucwords($employ->firstname)."</td>";
            $list .= "<td>".ucwords($employ->paterno)." ".ucwords($employ->materno)."</td>";
            $list .= "<td>".$estado."</td>";
            $list .= "<td><input type='checkbox' class='flat-orange' name='employedIdOperating' ".$checked." value='".str_replace("-","SL",$employ->rut)."'><span class='fa fa-comment minibtn-comment' data-comment='".$commentary."' id='".str_replace("-","SL",$employ->rut)."'></span></td>";
            $list .= "</tr>";

            $vuelta++;
        }
        $values .= "]";

        if($list == "")
            $list = "<tr><td colspan='5'>Sin Empleados Asociados</td></tr>";

        return View::make('asistencia.listEmployes',array(
                    'employes' => $list,
                    'centerName' => $centro,
                    'values' => $values,
                    'action' => $route,
                    'fecha' => $fecha
                ));
    }

    public static function getSelectEmployes($id=null){
        $options = "<option value='0'>Seleccione un Empleado</option>";
        $empleoyes = Empleado::where('active','=','1')->get();
        foreach ($empleoyes as $row){
            $selected = ($row->id == $id) ? "selected" : "";
            $options .= "<option value='".$row->id."' ".$selected.">".ucwords($row->nombre)." ".ucwords($row->ape_paterno)."</option>";
        }
        return $options;
    }

}