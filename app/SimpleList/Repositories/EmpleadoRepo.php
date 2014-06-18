<?php namespace SimpleList\Repositories;

use SimpleList\Entities\Empleado;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

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

    public static function getTableListEmployes($idCenter,$centro){
        $employes = Empleado::where('id','!=',Auth::user()->id_empleado)
                        ->where('centro_costo','=',$idCenter)
                        ->select("empleado.ape_paterno as paterno","empleado.ape_materno as materno","empleado.nombre as firstname","empleado.id as rut",'empleado.active as status')
                        ->get();
        $list = "";

        foreach ($employes as $employ){
            $estado = ($employ->status == 1) ? 'Activo' : 'Desactivado';

            $list .= "<tr>";
            $list .= "<td>".$employ->rut."</td>";
            $list .= "<td>".ucwords($employ->firstname)."</td>";
            $list .= "<td>".ucwords($employ->paterno)." ".ucwords($employ->materno)."</td>";
            $list .= "<td>".$estado."</td>";
            $list .= "<td><input type='checkbox' class='flat-orange' name='employedIdOperating' checked='checked' value='".$employ->rut."'></td>";
            $list .= "</tr>";
        }

        if($list == "")
            $list = "<tr><td colspan='5'>Sin Empleados Asociados</td></tr>";

        return View::make('asistencia.listEmployes',array(
                    'employes' => $list,
                    'centerName' => $centro
                ));
    }

}