<?php

use SimpleList\Libraries\Util;
use SimpleList\Repositories\JefaturaRepo;

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
            'menu' => Util::getMenu($user['name'],$user['img'])
        ));
    }

}
