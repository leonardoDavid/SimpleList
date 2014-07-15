<?php

use SimpleList\Repositories\EmpleadoRepo;
use SimpleList\Repositories\CentroRepo;
use SimpleList\Repositories\JefaturaRepo;
use SimpleList\Repositories\CargoRepo;
use SimpleList\Libraries\Util;
use SimpleList\Managers\EmpleadoManager;
use SimpleList\Managers\CentroManager;
use SimpleList\Managers\CargoManager;

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
        $user = JefaturaRepo::getUserData(Auth::user()->id);

        return View::make('admin.empleados',array(
            'titlePage' => "Administración",
            'description' => "Empleados",
            'route' => Util::getTracert(),
            'menu' => Util::getMenu($user['name'],$user['img']),
            'user' => JefaturaRepo::getUserNotification($user),
            'cargos' => CargoRepo::getSelectCargos(),
            'centers' => CentroRepo::getSelectCenters(),
            'tipoContratos' => Util::getSelectAgreement(),
            'empleadosListTable' => EmpleadoRepo::getEmpleoyesWithoutMe()
        ));
    }

    public function getCentros(){
        $user = JefaturaRepo::getUserData(Auth::user()->id);

        return View::make('admin.centros',array(
            'titlePage' => "Administración",
            'description' => "Centro de Costos",
            'route' => Util::getTracert(),
            'menu' => Util::getMenu($user['name'],$user['img']),
            'user' => JefaturaRepo::getUserNotification($user),
            'centersListTable' => CentroRepo::all()
        ));
    }

    public function getCargos(){
        $user = JefaturaRepo::getUserData(Auth::user()->id);

        return View::make('admin.cargos',array(
            'titlePage' => "Administración",
            'description' => "Cargos",
            'route' => Util::getTracert(),
            'menu' => Util::getMenu($user['name'],$user['img']),
            'user' => JefaturaRepo::getUserNotification($user),
            'cargosListTable' => CargoRepo::all()
        ));
    }

    public function addEmployed(){
        if(Request::ajax()){
            $response = EmpleadoManager::save();
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
            $response = CentroManager::save();
        }
        else{
            $response = array(
                'status' => false,
                'motivo' => "Error en la solicitud"
            );
        }
        return $response;
    }

    public function addCargo(){
        if(Request::ajax()){
            $response = CargoManager::save();
        }
        else{
            $response = array(
                'status' => false,
                'motivo' => "Error en la solicitud"
            );
        }
        return $response;
    }

    public function refreshCenter(){
        $response = array();
        $index = 0;
        $centersListTable = CentroRepo::all();
        foreach($centersListTable as $center){
            $tmp = array(
                'name' => $center->nombre,
                'active' => ($center->active == 1) ? "Activo" : "Deshabilitado",
                'added' => $center->created_at,
                'checkbox' => "<input type='checkbox' class='flat-orange' name='employedIdOperating' value='".$center->id."'>"
            );
            $response[$index] = $tmp;
            $index++;
        }
        return $response;
    }

    public function refreshEmployed(){
        $response = array();
        $index = 0;
        $UserListTable = EmpleadoRepo::getEmpleoyesWithoutMe();
        foreach($UserListTable as $employed){
            $tmp = array(
                'rut' => $employed->rut,
                'name' => ucwords($employed->firstname),
                'lastname' => ucwords($employed->paterno)." ".ucwords($employed->materno),
                'active' => ($employed->status == 1) ? "Activo" : "Deshabilitado",
                'checkbox' => "<input type='checkbox' class='flat-orange' name='employedIdOperating' value='".$employed->rut."'>"
            );
            $response[$index] = $tmp;
            $index++;
        }
        return $response;
    }

    public function refreshCargo(){
        $response = array();
        $index = 0;
        $cargoListTable = CargoRepo::all();
        foreach($cargoListTable as $cargo){
            $tmp = array(
                'name' => $cargo->nombre,
                'valor' => $cargo->valor_dia,
                'active' => ($cargo->active == 1) ? "Activo" : "Deshabilitado",
                'added' => $cargo->created_at,
                'checkbox' => "<input type='checkbox' class='flat-orange' name='cargoIdOperating' value='".$cargo->id."'>"
            );
            $response[$index] = $tmp;
            $index++;
        }
        return $response;
    }

    public function enabledEmployed(){
        if(Request::ajax()){
            $response = EmpleadoManager::enabled();
        }
        else{
            $response = array(
                'status' => false,
                'motivo' => "Error en la solicitud"
            );
        }
        return $response;
    }

    public function disabledEmployed(){
        if(Request::ajax()){
            $response = EmpleadoManager::disabled();
        }
        else{
            $response = array(
                'status' => false,
                'motivo' => "Error en la solicitud"
            );
        }
        return $response;
    }

    public function enabledCenter(){
        if(Request::ajax()){
            $response = CentroManager::enabled();
        }
        else{
            $response = array(
                'status' => false,
                'motivo' => "Error en la solicitud"
            );
        }
        return $response;
    }

    public function disabledCenter(){
        if(Request::ajax()){
            $response = CentroManager::disabled();
        }
        else{
            $response = array(
                'status' => false,
                'motivo' => "Error en la solicitud"
            );
        }
        return $response;
    }

    public function enabledCargo(){
        if(Request::ajax()){
            $response = CargoManager::enabled();
        }
        else{
            $response = array(
                'status' => false,
                'motivo' => "Error en la solicitud"
            );
        }
        return $response;
    }

    public function disabledCargo(){
        if(Request::ajax()){
            $response = CargoManager::disabled();
        }
        else{
            $response = array(
                'status' => false,
                'motivo' => "Error en la solicitud"
            );
        }
        return $response;
    }

    public function getInfoEmploy($id = null){
        if(is_null($id))
            $response = EmpleadoRepo::getInfo(Input::get('ids', null));
        else
            $response = EmpleadoRepo::getInfo($id);

        return json_encode($response);
    }

    public function getInfoCenter($id = null){
        if(is_null($id))
            $response = CentroRepo::getInfo(Input::get('ids', null));
        else
            $response = CentroRepo::getInfo($id);

        return json_encode($response);
    }

    public function getInfoCargo($id = null){
        if(is_null($id))
            $response = CargoRepo::getInfo(Input::get('ids', null));
        else
            $response = CargoRepo::getInfo($id);

        return json_encode($response);
    }

    public function editEmployed(){
        if(Request::ajax()){
            $response = EmpleadoManager::update();
        }
        else{
            $response = array(
                'status' => false,
                'motivo' => "Error en la solicitud",
                'abortEdit' => true
            );
        }
        return $response;
    }

    public function editCenter(){
        if(Request::ajax()){
            $response = CentroManager::update();
        }
        else{
            $response = array(
                'status' => false,
                'motivo' => "Error en la solicitud",
                'abortEdit' => true
            );
        }
        return $response;
    }

    public function editCargo(){
        if(Request::ajax()){
            $response = CargoManager::update();
        }
        else{
            $response = array(
                'status' => false,
                'motivo' => "Error en la solicitud",
                'abortEdit' => true
            );
        }
        return $response;
    }

}
