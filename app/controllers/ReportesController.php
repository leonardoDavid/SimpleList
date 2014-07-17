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
            $values['empleado'] = Util::clearRut($values['empleado']);
            $values['jefatura'] = Util::clearRut($values['jefatura']);
            $values['range'] = Util::getRangeDate($values['range']);
            $values['model'] = 'asistencia';
            $rules = $this->getRulesValidator($values);

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
                $filters = $this->generateFiltersToCSV($values);
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

    public function generateCSVReportPay(){
        if(Request::ajax()){
            $values = Input::get('values');
            $values['empleado'] = Util::clearRut($values['empleado']);
            $values['range'] = Util::getRangeDate($values['range']);
            $values['model'] = 'adelanto';
            $rules = $this->getRulesValidator($values);
            
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
                $filters = $this->generateFiltersToCSV($values);
                $dataReport = ReporteRepo::adelanto($filters);
                
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
            $ext = ($ext == 'csv') ? 'txt' : $ext;

            $headers = array(
                'Content-Type' => $type,
                'Content-Disposition' => 'attachment; filename=reporte.'.$ext,
            );
            return Response::make(readfile($fileLocation), 200, $headers);
        }
        else
            return App::abort(404);
    }

    public function generateCSVReportAllEmployes(){
        if(Request::ajax()){
            $dataReport = ReporteRepo::allEmployes();
            $filters = array(
                'model' => 'empleado'
            );

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
        else{
            $response = array(
                'status' => false,
                'motivo' => 'Error en el tipo de solicitud de datos'
            );
        }

        return json_encode($response);
    }

    public function generateCSVReportAllCenter(){
        if(Request::ajax()){
            $dataReport = ReporteRepo::allCenters();
            $filters = array(
                'model' => 'centro_costo'
            );

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
        else{
            $response = array(
                'status' => false,
                'motivo' => 'Error en el tipo de solicitud de datos'
            );
        }

        return json_encode($response);
    }

    public function generateCSVReportAllCargos(){
        if(Request::ajax()){
            $dataReport = ReporteRepo::allCargos();
            $filters = array(
                'model' => 'cargo'
            );

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
        else{
            $response = array(
                'status' => false,
                'motivo' => 'Error en el tipo de solicitud de datos'
            );
        }

        return json_encode($response);
    }

    /*
    |--------------------------------------------------------------------------
    | Funciones Privadas
    |--------------------------------------------------------------------------
    |
    | Estas son funciones sirven para sacar ciertos campos o filtros para la
    | generación de los reportes.
    |
    */
    private function getRulesValidator($values){
        $columns = array();
        $rules = array();

        if(array_key_exists('centro', $values) && !empty($values['centro']) && $values['centro'] != 0 ){
            $columns['centro'] = $values['centro'];
            $rules['centro'] = 'exists:centro_costo,id';
        }        
        if(array_key_exists('empleado', $values) && !empty($values['empleado']) && $values['empleado'] != 0 ){
            $columns['empleado'] = $values['empleado'];
            $rules['empleado'] = 'exists:empleado,id';
        }
        if(array_key_exists('jefatura', $values) && !empty($values['jefatura']) && $values['jefatura'] != 0 ){
            $columns['jefatura'] = $values['jefatura'];
            $rules['jefatura'] = 'exists:jefatura,id_empleado';
        }
        if(array_key_exists('range', $values) && !empty($values['range']) ){
            $columns['initDate'] = $values['range']['init'];
            $columns['lastDate'] = $values['range']['last'];
            $rules['initDate'] = 'after_init_date:'.$values['model'];
            $rules['lastDate'] = 'before_last_date:'.$values['model'];
        }
        if(array_key_exists('ifComments', $values)){
            $columns['hasComments'] = $values['ifComments'];
            $rules['hasComments'] = 'in:0,1';
        }

        return array(
            'columns' => $columns,
            'rules' => $rules
        );
    }

    private function generateFiltersToCSV($values){
        $filters = array();

        if(array_key_exists('centro', $values) && !empty($values['centro']) && $values['centro'] != 0 ){
            $filters['center'] = $values['centro'];
        }        
        if(array_key_exists('empleado', $values) && !empty($values['empleado']) && $values['empleado'] != 0 ){
            $filters['employ'] = $values['empleado'];
        }
        if(array_key_exists('jefatura', $values) && !empty($values['jefatura']) && $values['jefatura'] != 0 ){
            $filters['boss'] = $values['jefatura'];
        }
        if(array_key_exists('range', $values) && !empty($values['range']) ){
            $tmp = explode('/',$values['range']['init']);
            $filters['init'] = (is_array($tmp) && count($tmp) == 3) ? $tmp[2]."-".$tmp[1]."-".$tmp[0] : null;
            $tmp = explode('/',$values['range']['last']);
            $filters['last'] = (is_array($tmp) && count($tmp) == 3) ? $tmp[2]."-".$tmp[1]."-".$tmp[0] : null;
        }
        if(array_key_exists('ifComments', $values))
            $filters['hasComments'] = $values['ifComments'];

        $filters['model'] = $values['model'];

        return $filters;
    }

    private function generateFileCSV($model,$filters){
        $response = array();
        $headersCSV = array();

        if($filters['model'] == "adelanto" || $filters['model'] == "asistencia" || $filters['model'] == "empleado"){
            array_push($headersCSV, 'RUT');
            array_push($headersCSV, 'Nombre');
            array_push($headersCSV, 'Apellido Paterno');
            array_push($headersCSV, 'Apellido Materno');
            array_push($headersCSV, 'Cargo');
            array_push($headersCSV, 'Valor Día');
        }
        if(count($model) > 0 && $filters['model'] == "adelanto"){
            array_push($headersCSV, 'Monto');
            array_push($headersCSV, 'Fecha de Adelanto');
        }
        if(count($model) > 0 && $filters['model'] == "asistencia"){
            array_push($headersCSV, 'Presente');
            array_push($headersCSV, 'Fecha de Lista');
        }
        if(count($model) > 0 && $filters['model'] == "empleado"){
            array_push($headersCSV, 'Sueldo Base');
            array_push($headersCSV, 'Cargas Familiares');
            array_push($headersCSV, 'Direccion');
            array_push($headersCSV, 'Fono Fijo');
            array_push($headersCSV, 'Fono Movil');
            array_push($headersCSV, 'Prevision');
            array_push($headersCSV, 'AFP');
            array_push($headersCSV, 'Centro de Costo');
            array_push($headersCSV, 'Tipo Contrato');
            array_push($headersCSV, 'Inicio Contrato');
            array_push($headersCSV, 'Fin Contrato');
            array_push($headersCSV, 'Estado');
            array_push($headersCSV, 'Ingresado en Sistema');
            array_push($headersCSV, 'Ultima Actualizacion');
        }
        if(count($model) > 0 && $filters['model'] == "centro_costo"){
            array_push($headersCSV, 'Nombre');
            array_push($headersCSV, 'Estado');
            array_push($headersCSV, 'Creado en el Sistema');
            array_push($headersCSV, 'Ultima Actualizacion');
        }

        if(count($model) > 0 && $filters['model'] == "cargo"){
            array_push($headersCSV, 'Nombre');
            array_push($headersCSV, 'Valor Dia');
            array_push($headersCSV, 'Estado');
            array_push($headersCSV, 'Creado en el Sistema');
            array_push($headersCSV, 'Ultima Actualizacion');
        }

        if(array_key_exists('center', $filters))
            array_push($headersCSV, 'Centro');
        if(array_key_exists('boss', $filters))
            array_push($headersCSV, 'Jefatura');
        if( array_key_exists('hasComments', $filters) && $filters['hasComments'] == 1 )
            array_push($headersCSV, 'Comentario');

        if(count($model) > 0){
            try{
                $fileName = date('d-m-Y_H:i:s')."_By-".Auth::user()->username."_".$filters['model'];
                $fileLocation = app_path().'/SimpleList/Files/Reports/'.$fileName.".csv";
                $file = fopen( $fileLocation, 'w');

                fputcsv($file, $headersCSV);
                foreach ($model as $row){
                    $tmp = array();

                    if($filters['model'] == "adelanto" || $filters['model'] == "asistencia" || $filters['model'] == "empleado"){
                        array_push($tmp, $row->rut_empleado);
                        array_push($tmp, $row->nombre_empleado);
                        array_push($tmp, $row->ape_paterno);
                        array_push($tmp, $row->ape_materno);
                        array_push($tmp, $row->cargo);
                        array_push($tmp, $row->valor_dia);
                    }
                    if(count($model) > 0 && $filters['model'] == "asistencia"){
                        array_push($tmp, $row->asistio);
                        array_push($tmp, $row->tomada);
                    }
                    if(count($model) > 0 && $filters['model'] == "adelanto"){
                        array_push($tmp, $row->monto);
                        array_push($tmp, $row->dado);
                    }
                    if(count($model) > 0 && $filters['model'] == "empleado"){
                        array_push($tmp, $row->sueldo);
                        array_push($tmp, $row->cargas);
                        array_push($tmp, $row->direccion);
                        array_push($tmp, $row->fijo);
                        array_push($tmp, $row->movil);
                        array_push($tmp, $row->prevision);
                        array_push($tmp, $row->afp);
                        array_push($tmp, $row->centro_costo);
                        array_push($tmp, $row->tipo_contrato);
                        array_push($tmp, $row->inicio_contrato);
                        array_push($tmp, $row->fin_contrato);
                        $estado = ($row->estado == 1) ? 'Habilitado' : 'Deshabilitado';
                        array_push($tmp, $estado);
                        array_push($tmp, $row->creado);
                        array_push($tmp, $row->actualizado);
                    }
                    if(count($model) > 0 && $filters['model'] == "centro_costo"){
                        array_push($tmp, $row->nombre);
                        $estado = ($row->estado == 1) ? 'Habilitado' : 'Deshabilitado';
                        array_push($tmp, $estado);
                        array_push($tmp, $row->creado);
                        array_push($tmp, $row->actualizado);
                    }
                    if(count($model) > 0 && $filters['model'] == "cargo"){
                        array_push($tmp, $row->nombre);
                        array_push($tmp, $row->valor_dia);
                        $estado = ($row->estado == 1) ? 'Habilitado' : 'Deshabilitado';
                        array_push($tmp, $estado);
                        array_push($tmp, $row->creado);
                        array_push($tmp, $row->actualizado);
                    }

                    if(array_key_exists('center', $filters))
                        array_push($tmp, $row->centro_costo);
                    if(array_key_exists('boss', $filters))
                        array_push($tmp, $row->rut_jefatura);
                    if( array_key_exists('hasComments', $filters) && $filters['hasComments'] == 1 )
                        array_push($tmp, $row->comentario);

                    fputcsv($file, $tmp);
                }
                fclose($file);

                switch ($filters['model']) {
                    case 'adelanto':
                        $route = 'adelantos';
                        break;

                    case 'empleado':
                        $route = 'admin/empleados';
                        break;

                    case 'centro_costo':
                        $route = 'admin/centros';
                        break;

                    case 'cargo':
                        $route = 'admin/cargos';
                        break;
                    
                    default:
                        $route = $filters['model'];
                        break;
                }

                $response = array(
                    'status' => true,
                    'routeDownload' => '/'.$route.'/files/'.Crypt::encrypt($fileName)
                );

            }catch(Exception $e){
                $response = array(
                    'status' => false,
                    'motivo' => "Error al tratar de Generar el Archivo",
                    'exception' => $e->getMessage()
                );
            }
        }
        else
            $response = array(
                'status' => false,
                'motivo' => "No existen registros asociados",
                'exception' => 'No Data Found'
            );

        return $response;
    }

}
