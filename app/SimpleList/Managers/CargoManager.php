<?php namespace SimpleList\Managers;

use SimpleList\Entities\Cargo;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class CargoManager{
	
	/*
    |--------------------------------------------------------------------------
    | Manager de Cargo
    |--------------------------------------------------------------------------
    |
    | Estas funciones son ituliozadas para agregar registros, actualizar o 
    | deshabilitar cargos dentro del sistema
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
            'name' => $name,
            'valor' => Input::get('valor')
        );

        $rules = array(
            'name' => 'required|unique:cargo,nombre',
            'valor' => 'required|numeric|min:1'
        );

        if($update){
            $values['id'] = $id;
            $rules['id'] = 'required|exists:cargo,id';
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
                $cargo = Cargo::find($id);
            }
            else{
                $cargo = new Cargo;
                $cargo->active = 1;                
            }
            $cargo->nombre = $name;
            $cargo->valor_dia = Input::get('valor');
            try {
                $cargo->save();
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
        $cargoEnabled = array();
        foreach ($ids as $cargo){
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
                array_push($cargoEnabled, $cargo);
            }
        }

        if($pased){
            foreach ($cargoEnabled as $id){
                $cargo = Cargo::find($id);
                $cargo->active = (is_null($disabled)) ? 1 : 0;
                try {
                    $cargo->save();
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
                'motivo' => "Hay cargos no registrados en el sistema, imposible actualizar"
            );            
        }

        return $response;
    }

    public static function disabled(){
        return CargoManager::enabled(1);
    }

    public static function update(){
        return CargoManager::save(true);
    }

}