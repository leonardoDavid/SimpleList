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
            'menu' => Util::getMenu($user['name'],$user['img']),
            'cargos' => Util::getSelectCargos(),
            'centers' => Util::getSelectCenters()
        ));
    }

    public function getCentros(){
        $user = Util::getUserData(Auth::user()->id);

        return View::make('admin.centros',array(
            'titlePage' => "Administración",
            'description' => "Centro de Costos",
            'route' => Util::getTracert(),
            'user' => Util::getUserNotification($user),
            'menu' => Util::getMenu($user['name'],$user['img'])
        ));
    }

    public function addEmployed(){
        if(Request::ajax()){

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
        }
        else{
            $response = array(
                'status' => false,
                'motivo' => "Error en la solicitud"
            );
        }
        return $response;
    }

    public function addCenter(){
        if(Request::ajax()){

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
