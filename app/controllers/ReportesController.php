<?php

use SimpleList\Libraries\Util;
use SimpleList\Repositories\JefaturaRepo;
use SimpleList\Repositories\EmpleadoRepo;
use SimpleList\Repositories\CentroRepo;
use SimpleList\Repositories\ReporteRepo;

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

    public function showFilterPay(){
        $user = JefaturaRepo::getUserData(Auth::user()->id);

        return View::make('reportes.adelantos',array(
            'titlePage' => "Adelantos",
            'description' => "Centro de Reportes",
            'user' => JefaturaRepo::getUserNotification($user),
            'route' => Util::getTracert(),
            'menu' => Util::getMenu($user['name'],$user['img']),
            'centros' => CentroRepo::getSelectCenters(),
            'empleados' => EmpleadoRepo::getSelectEmployes()
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
                $filters = $this->generateFiltersToCSV($values,$empleadoRUT,$jefaturaRUT,$fecha);
                $dataReport = ReporteRepo::asistencia($filters);
                
                $report = $this->generateFileCSV($dataReport,$filters);
                if ($report['status']) {
                    $response = array(
                        'status' => true,
                        'download' => $report['routeDownload']
                    );
                }
                else{
                    $response = array(
                        'status' => false,
                        'motivo' => $report['motivo'],
                        'mensajes' => "",
                        'ex' => $report['exception']
                    );
                }
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

    public function getFileReportCSV($hashName){
        $fileName = Crypt::decrypt($hashName);
        $fileLocation = app_path().'/SimpleList/Files/Reports/'.$fileName.".csv";
        if(file_exists($fileLocation)){
            $resource = finfo_open(FILEINFO_MIME_TYPE);
            $type = finfo_file($resource , $fileLocation);
            finfo_close($resource);

            $partes = explode('.', $fileLocation);
            $total = count($partes);
            $ext = ($total > 0) ? $partes[$total -1] : 'txt';

            $headers = array(
                'Content-Type' => $type,
                'Content-Disposition' => 'attachment; filename=reporte.'.$ext,
            );
            return Response::make(readfile($fileLocation), 200, $headers);
        }
        else
            return App::abort(404);
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

    private function generateFiltersToCSV($values,$empleadoRUT,$jefaturaRUT,$fecha){
        $filters = array();

        if(!empty($values['centro']) && $values['centro'] != 0 ){
            $filters['center'] = $values['centro'];
        }        
        if(!empty($empleadoRUT) && $empleadoRUT != 0 ){
            $filters['employ'] = $empleadoRUT;
        }
        if(!empty($jefaturaRUT) && $jefaturaRUT != 0 ){
            $filters['boss'] = $jefaturaRUT;
        }
        if( !empty($fecha['init']) && !empty($fecha['last']) ){
            $tmp = explode('/',$fecha['init']);
            $filters['init'] = $tmp[2]."-".$tmp[1]."-".$tmp[0];
            $tmp = explode('/',$fecha['last']);
            $filters['last'] = $tmp[2]."-".$tmp[1]."-".$tmp[0];
        }
        $filters['hasComments'] = $values['ifComments'];

        return $filters;
    }

    private function generateFileCSV($model,$filters){
        $response = array();
        $headersCSV = array();

        array_push($headersCSV, 'RUT');
        array_push($headersCSV, 'Nombre');
        array_push($headersCSV, 'Apellido Paterno');
        array_push($headersCSV, 'Apellido Materno');
        array_push($headersCSV, 'Cargo');
        array_push($headersCSV, 'Valor Día');
        array_push($headersCSV, 'Presente');
        array_push($headersCSV, 'Fecha de Lista');

        if(array_key_exists('center', $filters))
            array_push($headersCSV, 'Centro');
        if(array_key_exists('boss', $filters))
            array_push($headersCSV, 'Jefatura');
        if($filters['hasComments'] == 1 )
            array_push($headersCSV, 'Comentario');

        try{
            $fileName = date('d-m-Y_H:i:s')."_By".Auth::user()->username;
            $fileLocation = app_path().'/SimpleList/Files/Reports/'.$fileName.".csv";
            $file = fopen( $fileLocation, 'w');

            fputcsv($file, $headersCSV);
            foreach ($model as $row){
                $tmp = array();

                array_push($tmp, $row->rut_empleado);
                array_push($tmp, $row->nombre_empleado);
                array_push($tmp, $row->ape_paterno);
                array_push($tmp, $row->ape_materno);
                array_push($tmp, $row->cargo);
                array_push($tmp, $row->valor_dia);
                array_push($tmp, $row->asistio);
                array_push($tmp, $row->tomada);

                if(array_key_exists('center', $filters))
                    array_push($tmp, $row->centro_costo);
                if(array_key_exists('boss', $filters))
                    array_push($tmp, $row->rut_jefatura);
                if($filters['hasComments'] == 1 )
                    array_push($tmp, $row->comentario);

                fputcsv($file, $tmp);
            }
            fclose($file);

            $response = array(
                'status' => true,
                'routeDownload' => '/asistencia/files/'.Crypt::encrypt($fileName)
            );

        }catch(Exception $e){
            $response = array(
                'status' => false,
                'motivo' => "Error al tratar de Generar el Archivo",
                'exception' => $e->getMessage()
            );
        }

        return $response;
    }

}
