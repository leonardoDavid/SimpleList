<?php

use SimpleList\Libraries\Util;
use SimpleList\Repositories\JefaturaRepo;
use SimpleList\Repositories\EmpleadoRepo;
use SimpleList\Repositories\CentroRepo;

class ReportesController extends BaseController {
    /*
    |--------------------------------------------------------------------------
    | Metodos de Reportes
    |--------------------------------------------------------------------------
    |
    | Estas son funciones que responden a metodos de las rutas en relacion a 
    | los reportes que se soliciten en el sistema, donde se encuentran reponse
    | de vistas a realizacion de filtros, exportacion CSV, entre otros.
    |
    */
    public function showFilterAssistance(){
        $user = JefaturaRepo::getUserData(Auth::user()->id);

        return View::make('reportes.asistencia',array(
            'titlePage' => "Asistencia",
            'description' => "Centro de Reportes",
            'user' => JefaturaRepo::getUserNotification($user),
            'route' => Util::getTracert(),
            'menu' => Util::getMenu($user['name'],$user['img']),
            'centros' => CentroRepo::getSelectCenters(),
            'empleados' => EmpleadoRepo::getSelectEmployes(),
            'jefaturas' => JefaturaRepo::getSelectJefatura()
        ));
    }

    public function exportCSVFile(){
        if(Request::ajax()){
            $values = Input::get('values');
            $empleadoRUT = Util::clearRut($values['empleado']);
            $jefaturaRUT = Util::clearRut($values['jefatura']);
            $fecha = Util::getRangeDate($values['range']);

            $validations = Validator::make(
                array(
                    'centro' => $values['centro'],
                    'empleado' => $empleadoRUT,
                    'jefatura' => $jefaturaRUT,
                    'initDate' => $fecha['init'],
                    'lastDate' => $fecha['last'],
                    'hasComments' => $values['ifComments']
                ),
                array(
                    'centro' => 'exists:centro_costo,id',
                    'empleado' => 'exists:empleado,id',
                    'jefatura' => 'exists:jefatura,id',
                    'initDate' => 'after_init_date',
                    'lastDate' => 'before_today',
                    'hasComments' => 'in:1,2'
                )
            );

            if($validations->fails()){
                $errores = $validations->messages()->all();
                $mensajes = "<ul>";
                foreach ($errores as $row){
                    $mensajes .= "<li>".$row."</li>";
                }
                $mensajes .= "</ul>";
                $response = array(
                    'status' => false,
                    'motivo' => 'Existen errores en los filtros entregados para realizar el reporte:',
                    'mensajes' => $mensajes
                );
            }
            else{
                $response = array(
                    'status' => true
                );
            }

        }
        else{
            $response = array(
                'status' => false,
                'motivo' => 'Error en el tipo de solicitud de datos'
            );
        }

        return json_encode($response);
    }

}
