<?php namespace SimpleList\Managers;

use SimpleList\Entities\Empleado;
use SimpleList\Repositories\EmpleadoRepo;
use SimpleList\Libraries\Util;
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
    public static function save($update = false){
        $rutEmployed = Util::clearRut(Input::get('rut'));

        $values = array(
            'rut' => $rutEmployed,
            'name' => Input::get('name'),
            'ape_paterno' => Input::get('ape_paterno'),
            'direction' => Input::get('direction'),
            'phone' => Input::get('phone'),
            'movil' => Input::get('movil'),
            'prevision' => Input::get('prevision'),
            'cargo' => Input::get('cargo'),
            'cargas' => Input::get('cargas'),
            'sueldo' => Input::get('sueldo'),
            'centro' => Input::get('centro'),
            'afp' => Input::get('afp'),
            'fecha_contrato' => Input::get('fechaIngreso'),
            'fecha_termino' => Input::get('fechaSalida'),
            'tipo_contrato' => Input::get('tipo')
        );

        $filters = array(
            'rut' => 'required|unique:empleado,id',
            'name' => 'required',
            'ape_paterno' => 'required',
            'direction' => 'required',
            'phone' => 'numeric',
            'movil' => 'required|numeric',
            'prevision' => 'required',
            'cargo' => 'required|numeric',
            'centro' => 'required|numeric',
            'sueldo' => 'required|numeric',
            'cargas' => 'required|numeric',
            'afp' => 'required',
            'fecha_contrato' => 'required|regex:/[0-9]{2}\/[0-9]{2}\/[0-9]{4}/|fecha',
            'fecha_termino' => 'required_if:tipo_contrato,1|required_if:tipo_contrato,2|regex:/[0-9]{2}\/[0-9]{2}\/[0-9]{4}/|fecha',
            'tipo_contrato' => 'required|in:1,2,3'
        );

        if($update)
            $filters['rut'] = 'exists:empleado,id';

        $validation = Validator::make($values,$filters);

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
                'detalle' => "<strong>Woou! </strong> No se ha podido ingresar el registro ya que hay campos invalidos:",
                'abortEdit' => true
            );
        }
        else{
            if($update){
                $empleado = Empleado::find($rutEmployed);
            }
            else{
                $empleado = new Empleado;
                $empleado->id = $rutEmployed;
                $empleado->active = 1;
            }
            $empleado->nombre = Input::get('name');
            $empleado->ape_paterno = Input::get('ape_paterno');
            $empleado->ape_materno = Input::get('ape_materno',null);
            $empleado->direccion = Input::get('direction');
            $empleado->fono_fijo = Input::get('phone',null);
            $empleado->fono_movil = Input::get('movil');
            $empleado->prevision = strtoupper(Input::get('prevision'));
            $empleado->cargo = Input::get('cargo');
            $empleado->centro_costo = Input::get('centro');
            $empleado->sueldo_base = Input::get('sueldo');
            $empleado->carga_familiar = Input::get('cargas');
            $empleado->afp = strtoupper(Input::get('afp'));
            $empleado->tipo_contrato = Util::selectTipoContrato(Input::get('tipo'));
            $empleado->ingreso_contrato = Util::toDate(Input::get('fechaIngreso'));
            $empleado->vencimiento_contrato = Util::toDate(Input::get('fechaSalida'));
            try {
                $empleado->save();
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
        $ruts = explode(",", Input::get('ids'));
        $pased = true;
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
            foreach ($rutsEnabled as $rut){
                $empleado = Empleado::find($rut);
                $empleado->active = (is_null($disabled)) ? 1 : 0;
                try {
                    $empleado->save();
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
        return EmpleadoManager::enabled(1);
    }

    public static function update(){
        return EmpleadoManager::save(true);
    }

}