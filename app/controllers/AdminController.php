<?php
class AdminController extends BaseController {

    /*
    |--------------------------------------------------------------------------
    | Metodos de Administracion
    |--------------------------------------------------------------------------
    |
    | Estas son funciones que responden a metodos de las rutas en relaxcion 
    | a todo lo que tiene que ver con la administracion del sistema, como por
    | ejemplo agregar empleados, eliminar, centros de costos, jefaturas, etc.
    |
    */
    public function getEmpleados(){
        $user = Util::getUserData(Auth::user()->id);

        return View::make('admin.empleados',array(
            'titlePage' => "Administración",
            'description' => "Empleados",
            'route' => Util::getTracert(),
            'user' => Util::getUserNotification($user),
            'menu' => Util::getMenu($user['name'],$user['img'])
        ));
    }

    public function addEmployed(){
        if(Request::ajax()){
            $validation = Validator::make(
                array(
                    'name' => Input::get('name'),
                    'ape_paterno' => Input::get('ape_paterno'),
                    'ape_materno' => Input::get('ape_materno'),
                    'direction' => Input::get('direction'),
                    'phone' => Input::get('phone'),
                    'movil' => Input::get('movil'),
                    'prevision' => Input::get('prevision'),
                    'cargo' => Input::get('cargo'),
                    'centro' => Input::get('centro')
                ),
                array(
                    'name' => 'required',
                    'ape_paterno' => 'required',
                    'ape_materno' => 'required',
                    'direction' => 'required',
                    'phone' => 'numeric',
                    'movil' => 'required|numeric|min:8',
                    'prevision' => 'required',
                    'cargo' => 'required',
                    'centro' => 'required'
                )
            );

            if($validation->fails()){
                $messages = $validation->messages();
                foreach ($messages as $error){
                    break;
                }
                $response = array(
                    'status' => false,
                    'motivo' => "Campos ingresados malos"
                );
            }
            else{
                $empleado = new Empleado;
                $empleado->nombre = Input::get('name');
                $empleado->ape_paterno = Input::get('ape_paterno');
                $empleado->ape_materno = Input::get('ape_materno',null);
                $empleado->direccion = Input::get('direction');
                $empleado->fono_fijo = Input::get('phone',null);
                $empleado->fono_movil = Input::get('movil');
                $empleado->prevision = Input::get('prevision');
                $empleado->cargo = Input::get('cargo');
                $empleado->centro_costo = Input::get('centro');

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
        }
        else{
            $response = array(
                'status' => false,
                'motivo' => "Error en la solicitud"
            );
        }
        return $response;
    }

}
