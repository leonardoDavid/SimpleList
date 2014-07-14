<?php namespace SimpleList\Repositories;

use SimpleList\Entities\CentroCosto;
use Illuminate\Support\Facades\Validator;

class CentroRepo{
	
	/*
    |--------------------------------------------------------------------------
    | Funciones Comunes
    |--------------------------------------------------------------------------
    |
    | Estas funciones son reutilizables por todos los metodos del controlador
    | que requieran informacion con respecto al modelo de CentroCosto
    |
    */

    public static function count(){
        return CentroCosto::where('active','=','1')->count();
    }

    public static function getSelectCenters($id=null){
        $options = "<option value='0'>Seleccione un Centro</option>";
        $centers = CentroCosto::where('active','=','1')->get();
        foreach ($centers as $row){
            $selected = ($row->id == $id) ? "selected" : "";
            $options .= "<option value='".$row->id."' ".$selected.">".$row->nombre."</option>";
        }
        return $options;
    }

    public static function all(){
        return CentroCosto::all();
    }

    public static function find($id){
        return CentroCosto::find($id);
    }

    public static function getInfo($id = null){
        if(!is_null($id)){
            $centers = explode(",", $id);
            $pased = true;
            if(count($centers) > 1){
                //Busqueda de mucho centros de costo
                $centersEnabled = array();
                foreach ($centers as $center){
                    $validation = Validator::make(
                        array(
                            'id' => $center
                        ),
                        array(
                            'id' => 'required|exists:centro_costo,id'
                        )
                    );

                    if($validation->fails()){
                        $pased = false;
                        break;
                    }
                    else{
                        array_push($centersEnabled, $center);
                    }
                }

                if($pased){
                    $cont = 0;
                    foreach ($centersEnabled as $id){
                        $centro = CentroCosto::find($id);
                        $centrosResponse[$cont] = array(
                            'id' => $centro->id,
                            'nombre' => $centro->nombre
                        );
                        $cont++;
                    }
                    $response = array(
                        'status' => true,
                        'centers' => $centrosResponse
                    );
                }
                else{
                    $response = array(
                        'status' => false,
                        'motivo' => "Hay Centros de Costo no registrados en el sistema, imposible obtener datos"
                    );            
                }
            }
            else{
                //Busqueda de un Usuario
                $validation = Validator::make(
                    array(
                        'id' => $id
                    ),
                    array(
                        'id' => 'required|exists:centro_costo,id'
                    )
                );

                if($validation->fails()){
                    $response = array(
                        'status' => false,
                        'motivo' => 'Centro de Costo no registrado en el Sistema'
                    );
                }
                else{
                    $centro = CentroCosto::find($id);

                    $centrosResponse[0] = array(
                        'id' => $centro->id,
                        'nombre' => $centro->nombre
                    );

                    $response = array(
                        'status' => true,
                        'centers' => $centrosResponse
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