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
    public static function save($update = false){
        $words = explode(" ", Input::get('name'));
        $id = Input::get('id');
        $name = "";
        foreach ($words as $word){
            $name .= ucwords($word)." ";
        }

        $values = array(
            'name' => $name
        );

        $rules = array(
            'name' => 'required|unique:centro_costo,nombre'
        );

        if($update){
            $values['id'] = $id;
            $rules['id'] = 'required|exists:centro_costo,id';
            unset($values['name']);
            unset($rules['name']);
        }

        $validation = Validator::make($values,$rules);

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
                'detalle' => "<strong>Woou! </strong> No se ha podido ingresar el registro ya que hay campos invalidos:",
                'abortEdit' => true
            );
        }
        else{
            if($update){
                $center = CentroCosto::find($id);
            }
            else{
                $center = new CentroCosto;
                $center->active = 1;                
            }
            $center->nombre = $name;
            try {
                $center->save();
                $response = array(
                    'status' => true
                );
            }catch (Exception $e) {
                $response = array(
                    'status' => false,
                    'motivo' => "Error al tratar de guardar",
                    'execption' => $e->getMessage(),
                    'abortEdit' => true
                );   
            }
        }

        return $response;
    }

    public static function enabled($disabled=null){
        $ids = explode(",", Input::get('ids'));
        $pased = true;
        $centersEnabled = array();
        foreach ($ids as $center){
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
            foreach ($centersEnabled as $id){
                $center = CentroCosto::find($id);
                $center->active = (is_null($disabled)) ? 1 : 0;
                try {
                    $center->save();
                    $status = true;
                }catch (Exception $e) {
                    $status = false;
                    $response = array(
                        'status' => false,
                        'motivo' => "Interrupción en el proceso de actualización",
                        'execption' => $e->getMessage()
                    );
                }
                if($status){
                    $response = array(
                        'status' => true
                    );
                }
            }
        }
        else{
            $response = array(
                'status' => false,
                'motivo' => "Hay usuarios no registrados en el sistema, imposible actualizar"
            );            
        }

        return $response;
    }

    public static function disabled(){
        return CentroManager::enabled(1);
    }

    public static function update(){
        return CentroManager::save(true);
    }

}