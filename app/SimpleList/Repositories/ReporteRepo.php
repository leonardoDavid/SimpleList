<?php namespace SimpleList\Repositories;

use SimpleList\Entities\Adelanto;
use SimpleList\Entities\Asistencia;
use SimpleList\Entities\Empleado;
use SimpleList\Entities\CentroCosto;
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
                $query->where('asistencia.id_empleado','=',$filters['employ']);
            }
            if(!empty($filters['boss']) && $filters['boss'] != 0){
                $query->join('jefatura_empleado','jefatura_empleado.id_empleado','=','empleado.id');
                $query->where('jefatura_empleado.id_jefatura','=',$filters['boss']);
                $query->addSelect('jefatura_empleado.id_jefatura as rut_jefatura');
            }
            if( !empty($filters['init']) && !empty($filters['last']) ){
                $query->whereBetween( DB::raw('DATE(asistencia.created_at)') ,array($filters['init'],$filters['last']) );
            }
            else{
                $d = new \DateTime(date('Y-m-01'));
                $query->whereBetween( DB::raw('DATE(asistencia.created_at)') ,array(date('Y-m-01'),$d->format('Y-m-t')) );
            }
            if( $filters['hasComments'] == 1 )
                $query->addSelect('asistencia.comentario as comentario');
        }
        else{
            $d = new \DateTime(date('Y-m-01'));
            $query->whereBetween( DB::raw('DATE(asistencia.created_at)') ,array(date('Y-m-01'),$d->format('Y-m-t')) );
        }

        return $query->get();
    }

    public static function adelanto($filters = null){
        $query = Adelanto::join('empleado','adelanto.id_empleado','=','empleado.id')
                        ->join('cargo','cargo.id','=','empleado.cargo')
                        ->select('empleado.nombre as nombre_empleado','empleado.ape_paterno','empleado.ape_materno','empleado.id as rut_empleado',
                                'cargo.nombre as cargo','cargo.valor_dia as valor_dia',
                                'adelanto.monto as monto','adelanto.created_at as dado');

        if(!is_null($filters) && count($filters) > 0){
            if(!empty($filters['center']) && $filters['center'] != 0){
                $query->join('centro_costo','centro_costo.id','=','empleado.centro_costo');
                $query->where('empleado.centro_costo','=',$filters['center']);
                $query->addSelect('centro_costo.nombre as centro_costo');
            }
            if(!empty($filters['employ']) && $filters['employ'] != 0){
                $query->where('adelanto.id_empleado','=',$filters['employ']);
            }
            if( !empty($filters['init']) && !empty($filters['last']) ){
                $query->whereBetween( DB::raw('DATE(adelanto.created_at)') ,array($filters['init'],$filters['last']) );
            }
            else{
                $d = new \DateTime(date('Y-m-01'));
                $query->whereBetween( DB::raw('DATE(adelanto.created_at)') ,array(date('Y-m-01'),$d->format('Y-m-t')) );
            }
        }
        else{
            $d = new \DateTime(date('Y-m-01'));
            $query->whereBetween( DB::raw('DATE(adelanto.created_at)') ,array(date('Y-m-01'),$d->format('Y-m-t')) );
        } 

        return $query->get();
    }

    public static function allEmployes(){
        //Datos del Epleado
        $query = Empleado::select('empleado.nombre as nombre_empleado','empleado.ape_paterno','empleado.ape_materno','empleado.id as rut_empleado',
                                'empleado.direccion as direccion','empleado.fono_fijo as fijo','fono_movil as movil','empleado.afp as afp',
                                'empleado.prevision as prevision','empleado.tipo_contrato as tipo_contrato','empleado.ingreso_contrato as inicio_contrato',
                                'empleado.vencimiento_contrato as fin_contrato','empleado.active as estado',
                                'empleado.created_at as creado','empleado.updated_at as actualizado');
                                
        //Datos del Cargo
        $query->join('cargo','cargo.id','=','empleado.cargo')
            ->addSelect('cargo.nombre as cargo','cargo.valor_dia as valor_dia');

        //Datos del Centro de Costo
        $query->join('centro_costo','centro_costo.id','=','empleado.centro_costo');
        $query->addSelect('centro_costo.nombre as centro_costo');

        return $query->get();
    }

    public static function allCenters(){
        //Datos del Epleado
        $query = CentroCosto::select('centro_costo.nombre as nombre','centro_costo.active as estado',
                                'centro_costo.created_at as creado','centro_costo.updated_at as actualizado');

        return $query->get();
    }

}