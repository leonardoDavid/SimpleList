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

    public function generateCSVReportAssistance(){
        if(Request::ajax()){
            $values = Input::get('values');
            $empleadoRUT = Util::clearRut($values['empleado']);
            $jefaturaRUT = Util::clearRut($values['jefatura']);
            $fecha = Util::getRangeDate($values['range']);
            $rules = $this->getRulesValidator($values,$empleadoRUT,$jefaturaRUT,$fecha);

            $validations = Validator::make(
                $rules['columns'],$rules['rules']
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
                $dataReport = ReporteRepo::asistencia($filtros);
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

    private function getRulesValidator($values,$empleadoRUT,$jefaturaRUT,$fecha){
        $columns = array();
        $rules = array();

        if(!empty($values['centro']) && $values['centro'] != 0 ){
            $columns['centro'] = $values['centro'];
            $rules['centro'] = 'exists:centro_costo,id';
        }        
        if(!empty($empleadoRUT) && $empleadoRUT != 0 ){
            $columns['empleado'] = $empleadoRUT;
            $rules['empleado'] = 'exists:empleado,id';
        }
        if(!empty($jefaturaRUT) && $jefaturaRUT != 0 ){
            $columns['jefatura'] = $jefaturaRUT;
            $rules['jefatura'] = 'exists:jefatura,id_empleado';
        }
        if(!empty($fecha['init'])){
            $columns['initDate'] = $fecha['init'];
            $rules['initDate'] = 'after_init_date';
        }
        if(!empty($fecha['last'])){
            $columns['lastDate'] = $fecha['last'];
            $rules['lastDate'] = 'before_last_date';
        }
        $columns['hasComments'] = $values['ifComments'];
        $rules['hasComments'] = 'in:0,1';

        return array(
            'columns' => $columns,
            'rules' => $rules
        );
    }

}
