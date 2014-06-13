<?php namespace SimpleList\Managers;

use SimpleList\Entities\Empleado;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class EmpleadoManager{
	
	/*
    |--------------------------------------------------------------------------
    | Manager de Empleado
    |--------------------------------------------------------------------------
    |
    | Estas funciones son ituliozadas para agregar registros, actualizar o 
    | deshabilitar empleados dentro del sistema
    |
    */
    public static function save(){
        $rutEmployed = str_replace(".", "", Input::get('rut'));
        $rutEmployed = str_replace(",", "", $rutEmployed);
        $rutEmployed = substr($rutEmployed, 0,count($rutEmployed)-2);
        $rutEmployed .= "-";
        $rutEmployed .= substr(Input::get('rut'), -1);

        $validation = Validator::make(
            array(
                'rut' => $rutEmployed,
                'name' => Input::get('name'),
                'ape_paterno' => Input::get('ape_paterno'),
                'direction' => Input::get('direction'),
                'phone' => Input::get('phone'),
                'movil' => Input::get('movil'),
                'prevision' => Input::get('prevision'),
                'cargo' => Input::get('cargo'),
                'centro' => Input::get('centro')
            ),
            array(
                'rut' => 'required|unique:empleado,id',
                'name' => 'required',
                'ape_paterno' => 'required',
                'direction' => 'required',
                'phone' => 'numeric',
                'movil' => 'required|numeric',
                'prevision' => 'required',
                'cargo' => 'required|numeric',
                'centro' => 'required|numeric'
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
                'motivo' => "Hay campos que no son correctos",
                'errores' => $mensajes,
                'detalle' => "<strong>Woou! </strong> No se ha podido ingresar el registro ya que hay campos invalidos:"
            );
        }
        else{
            $empleado = new Empleado;
            $empleado->id = $rutEmployed;
            $empleado->nombre = Input::get('name');
            $empleado->ape_paterno = Input::get('ape_paterno');
            $empleado->ape_materno = Input::get('ape_materno',null);
            $empleado->direccion = Input::get('direction');
            $empleado->fono_fijo = Input::get('phone',null);
            $empleado->fono_movil = Input::get('movil');
            $empleado->prevision = Input::get('prevision');
            $empleado->cargo = Input::get('cargo');
            $empleado->centro_costo = Input::get('centro');
            $empleado->active = 1;
            try {
                $empleado->save();
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