<?php namespace SimpleList\Repositories;

use SimpleList\Entities\Cargo;
use Illuminate\Support\Facades\Validator;

class CargoRepo{
	
	/*
    |--------------------------------------------------------------------------
    | Funciones Comunes
    |--------------------------------------------------------------------------
    |
    | Estas funciones son reutilizables por todos los metodos del controlador
    | que requieran informacion con respecto al modelo de Jefatura
    |
    */

    public static function getSelectCargos(){
        $options = "<option value='0'>Seleccione un Cargo</option>";
        $cargos = Cargo::where('active','=','1')->get();
        foreach ($cargos as $row){
            $options .= "<option value='".$row->id."'>".$row->nombre."</option>";
        }
        return $options;
    }

    public static function all(){
        return Cargo::all();
    }

    public static function getInfo($id = null){
        if(!is_null($id)){
            $cargos = explode(",", $id);
            $pased = true;
            if(count($cargos) > 1){
                //Busqueda de mucho centros de costo
                $cargosEnabled = array();
                foreach ($cargos as $cargo){
                    $validation = Validator::make(
                        array(
                            'id' => $cargo
                        ),
                        array(
                            'id' => 'required|exists:cargo,id'
                        )
                    );

                    if($validation->fails()){
                        $pased = false;
                        break;
                    }
                    else{
                        array_push($cargosEnabled, $cargo);
                    }
                }

                if($pased){
                    $cont = 0;
                    foreach ($cargosEnabled as $id){
                        $centro = Cargo::find($id);
                        $cargosResponse[$cont] = array(
                            'id' => $centro->id,
                            'nombre' => $centro->nombre,
                            'valor' => $centro->valor_dia
                        );
                        $cont++;
                    }
                    $response = array(
                        'status' => true,
                        'cargos' => $cargosResponse
                    );
                }
                else{
                    $response = array(
                        'status' => false,
                        'motivo' => "Hay Cargos no registrados en el sistema, imposible obtener datos"
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
                        'id' => 'required|exists:cargo,id'
                    )
                );

                if($validation->fails()){
                    $response = array(
                        'status' => false,
                        'motivo' => 'Cargo no registrado en el Sistema'
                    );
                }
                else{
                    $cargo = Cargo::find($id);

                    $cargosResponse[0] = array(
                        'id' => $cargo->id,
                        'nombre' => $cargo->nombre,
                        'valor' => $cargo->valor_dia
                    );

                    $response = array(
                        'status' => true,
                        'cargos' => $cargosResponse
                    );
                }
            }
        }
        else{
            $response = array(
                'status' => false,
                'motivo' => "No se envio un ID de cargo"
            );
        }

        return $response;
    }

}