<?php namespace SimpleList\Repositories;

use SimpleList\Entities\Empleado;
use SimpleList\Libraries\Util;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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

    public static function getInfo($id = null){
        if(!is_null($id)){
            $ruts = explode(",", $id);
            $pased = true;
            if(count($ruts) > 1){
                //Busqueda de mucho usuarios
                $rutsEnabled = array();
                foreach ($ruts as $employ){
                    $rutEmployed = Util::clearRut($employ);
                    $validation = Validator::make(
                        array(
                            'rut' => $rutEmployed
                        ),
                        array(
                            'rut' => 'required|exists:empleado,id'
                        )
                    );

                    if($validation->fails()){
                        $pased = false;
                        break;
                    }
                    else{
                        array_push($rutsEnabled, $rutEmployed);
                    }
                }

                if($pased){
                    $cont = 0;
                    foreach ($rutsEnabled as $rut){
                        $empleado = Empleado::find($rut);

                        $inicio = explode(" ", $empleado->ingreso_contrato);
                        $inicio = explode("-", $inicio[0]);
                        $fin = explode(" ", $empleado->vencimiento_contrato);
                        $fin = explode("-", $fin[0]);
                        switch ($empleado->tipo_contrato){
                            case 'Plazo Fijo':
                                $tipo = 1;
                                break;
                            case 'Por Hora':
                                $tipo = 2;
                                break;
                            case 'Indefinido':
                                $tipo = 3;
                                break;
                        }

                        $employes[$cont] = array(
                            'rut' => $empleado->id,
                            'nombre' => $empleado->nombre,
                            'paterno' => $empleado->ape_paterno,
                            'materno' => $empleado->ape_materno,
                            'direccion' => $empleado->direccion,
                            'fonoFijo' => $empleado->fono_fijo,
                            'fonoMovil' => $empleado->fono_movil,
                            'prevision' => $empleado->prevision,
                            'afp' => $empleado->afp,
                            'tipoContrato' => $tipo,
                            'inicioContrato' => $inicio[2]."/".$inicio[1]."/".$inicio[0],                        
                            'finContrato' => $fin[2]."/".$fin[1]."/".$fin[0],
                            'cargo' => $empleado->cargo,
                            'centroCosto' => $empleado->centro_costo,
                            'estado' => $empleado->active
                        );
                        $cont++;
                    }
                    $response = array(
                        'status' => true,
                        'employes' => $employes
                    );
                }
                else{
                    $response = array(
                        'status' => false,
                        'motivo' => "Hay usuarios no registrados en el sistema, imposible actualizar"
                    );            
                }
            }
            else{
                //Busqueda de un Usuario
                $validation = Validator::make(
                    array(
                        'rut' => $id
                    ),
                    array(
                        'rut' => 'required|exists:empleado,id'
                    )
                );

                if($validation->fails()){
                    $response = array(
                        'status' => false,
                        'motivo' => 'Usuario no registrado en el Sistema'
                    );
                }
                else{
                    $empleado = Empleado::find($id);

                    $inicio = explode(" ", $empleado->ingreso_contrato);
                    $inicio = explode("-", $inicio[0]);
                    $fin = explode(" ", $empleado->vencimiento_contrato);
                    $fin = explode("-", $fin[0]);
                    switch ($empleado->tipo_contrato){
                        case 'Plazo Fijo':
                            $tipo = 1;
                            break;
                        case 'Por Hora':
                            $tipo = 2;
                            break;
                        case 'Indefinido':
                            $tipo = 3;
                            break;
                    }

                    $employes[0] = array(
                        'rut' => $empleado->id,
                        'nombre' => $empleado->nombre,
                        'paterno' => $empleado->ape_paterno,
                        'materno' => $empleado->ape_materno,
                        'direccion' => $empleado->direccion,
                        'fonoFijo' => $empleado->fono_fijo,
                        'fonoMovil' => $empleado->fono_movil,
                        'prevision' => $empleado->prevision,
                        'afp' => $empleado->afp,
                        'tipoContrato' => $tipo,
                        'inicioContrato' => $inicio[2]."/".$inicio[1]."/".$inicio[0],                        
                        'finContrato' => $fin[2]."/".$fin[1]."/".$fin[0],
                        'cargo' => $empleado->cargo,
                        'centroCosto' => $empleado->centro_costo,
                        'estado' => $empleado->active
                    );

                    $response = array(
                        'status' => true,
                        'employes' => $employes
                    );
                }
            }
        }
        else{
            $response = array(
                'status' => false,
                'motivo' => "No se envio un ID de empleado"
            );
        }

        return $response;
    }

}