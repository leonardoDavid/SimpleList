<?php namespace SimpleList\Managers;

use SimpleList\Entities\Asistencia;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class AsistenciaManager{
	
	/*
    |--------------------------------------------------------------------------
    | Manager de Asistencia
    |--------------------------------------------------------------------------
    |
    | Estas funciones son ituliozadas para agregar la lista de asistencia
    |
    */
    public static function save(){
        $values = json_decode(Input::get('values'));
        $ruts = array();
        foreach ($values as $row){
            array_push($ruts, $row->rut."#%&".$row->comment);
        }
        $pased = true;
        $rutsEnabled = array();
        foreach ($ruts as $employ){

            $rutEmployed = str_replace(".", "", $employ);
            $rutEmployed = str_replace(",", "", $rutEmployed);
            $rutEmployed = str_replace("-", "", $rutEmployed);
            $rutEmployed = str_replace("SL", "", $rutEmployed);

            $dataContend = explode("#%&", $rutEmployed);
            $tmp = explode("ST", $dataContend[0]);

            $rutEmployed = substr($tmp[0], 0,count($tmp[0])-2);
            $rutEmployed .= "-";
            $rutEmployed .= substr($tmp[0], -1);

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
                array_push($rutsEnabled, $rutEmployed."ST".$tmp[1]."#%&".$dataContend[1]);
            }
        }

        if($pased){
            foreach ($rutsEnabled as $rut){
                $dataContend = explode("#%&", $rut);
                $tmp = explode("ST", $dataContend[0]);

                $asistencia = new  Asistencia();
                $asistencia->id_empleado = $tmp[0];
                $asistencia->active = $tmp[1];
                $asistencia->comentario = $dataContend[1];
                try {
                    $asistencia->save();
                    $status = true;
                }catch (Exception $e) {
                    $status = false;
                    $response = array(
                        'status' => false,
                        'motivo' => "Interrupción en el proceso de guardado",
                        'execption' => $e->getMessage()
                    );
                }
            }
            if($status){
                $response = array(
                    'status' => true
                );
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

}