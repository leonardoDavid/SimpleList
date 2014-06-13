<?php namespace SimpleList\Managers;

use SimpleList\Entities\CentroCosto;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class CentroManager{
	
	/*
    |--------------------------------------------------------------------------
    | Manager de Centro de Costo
    |--------------------------------------------------------------------------
    |
    | Estas funciones son ituliozadas para agregar registros, actualizar o 
    | deshabilitar centros de costo dentro del sistema
    |
    */
    public static function save(){
        $words = explode(" ", Input::get('name'));
        $name = "";
        foreach ($words as $word){
            $name .= ucwords($word)." ";
        }

        $validation = Validator::make(
            array(
                'name' => $name
            ),
            array(
                'name' => 'required|unique:centro_costo,nombre'
            )
        );

        if($validation->fails()){
            $errores = $validation->messages()->all();
            $mensajes = "<ul class='text-red'>";
            foreach ($errores as $row){
                $mensajes .= "<li>".$row."</li>";
            }
            $mensajes .= "</ul>";
            $response = array(
                'status' => false,
                'motivo' => "Campos incorrectos",
                'errores' => $mensajes,
                'detalle' => "<strong>Woou! </strong> No se ha podido ingresar el registro ya que hay campos invalidos:"
            );
        }
        else{
            $center = new CentroCosto;
            $center->nombre = $name;
            $center->active = 1;
            try {
                $center->save();
                $response = array(
                    'status' => true
                );
            }catch (Exception $e) {
                $response = array(
                    'status' => false,
                    'motivo' => "Error al tratar de guardar",
                    'execption' => $e->getMessage()
                );   
            }
        }

        return $response;
    }

}