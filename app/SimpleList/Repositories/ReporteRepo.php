<?php namespace SimpleList\Repositories;

use SimpleList\Entities\Adelanto;
use SimpleList\Entities\Asistencia;
use Illuminate\Support\Facades\DB;

class ReporteRepo{
	
	/*
    |--------------------------------------------------------------------------
    | Funciones Comunes
    |--------------------------------------------------------------------------
    |
    | Estas funciones son reutilizables por todos los metodos del controlador
    | que requieran informacion con respecto a la generacion de la informacion
    | para algun reporte en especifico
    |
    */

    public static function asistencia($filters = null){
        $query = Asistencia::join('empleado','asistencia.id_empleado','=','empleado.id')
                        ->join('cargo','cargo.id','=','empleado.cargo')
                        ->select('empleado.nombre as nombre_empleado','empleado.ape_paterno','empleado.ape_materno','empleado.id as rut_empleado',
                                'cargo.nombre as cargo','cargo.valor_dia as valor_dia',
                                'asistencia.active as asistio','asistencia.created_at as tomada');

        if(!is_null($filters) && count($filters) > 0){
            if(!empty($filters['center']) && $filters['center'] != 0){
                $query->join('centro_costo','centro_costo.id','=','empleado.centro_costo');
                $query->where('empleado.centro_costo','=',$filters['center']);
                $query->addSelect('centro_costo.nombre as centro_costo');
            }
            if(!empty($filters['employ']) && $filters['employ'] != 0){
                $query->where('empleado.id','=',$filters['employ']);
            }
            if(!empty($filters['boss']) && $filters['boss'] != 0){
                $query->join('jefatura_empleado','jefatura_empleado.id_empleado','=','empleado.id');
                $query->where('jefatura_empleado.id_jefatura','=',$filters['boss']);
                $query->addSelect('jefatura_empleado.id_jefatura as rut_jefatura');
            }
            if( !empty($filters['init']) && !empty($filters['last']) ){
                $query->whereBetween( DB::raw('DATE(asistencia.created_at)') ,array($filters['init'],$filters['last']) );
            }
            if( $filters['hasComments'] == 1 )
                $query->addSelect('asistencia.comentario as comentario');
        }       

        return $query->get();
    }

}