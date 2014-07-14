<?php

use SimpleList\Entities\Empleado;

/**
* Se crean empleados de pruebas para trabajar
*/
class EmpleadosSeeder extends Seeder {
    public function run(){      
        //Para un Admin  
    	Empleado::create(array(
            'id' => '11111111-1',
    		'nombre' => "Admin",
            'ape_paterno' => "Swert",
            'direccion' => "Av. Siempre Vivas #0254, Quilicumbia - Santiago,Chile",
			'fono_movil' => 965996826,
            'prevision' => "ISAPRE",
            'afp' => 'MODELO',
            'img_perfil' => "/img/profile/grumpy.jpg",
            'tipo_contrato' => "Indefinido",
            'ingreso_contrato' => "2014-01-02 07:31:40",
            'vencimiento_contrato' => "2099-12-12 23:59:59",
            'cargo' => 1,
            'centro_costo' => 1,
            'active' => 1
        ));

        //Para un test de empleado
        Empleado::create(array(
            'id' => '22222222-2',
            'nombre' => "Test",
            'ape_paterno' => "Empleado",
            'ape_materno' => "Swert",
            'direccion' => "Av. Siempre Vivas #0978, Renca la Lleva - Santiago,Chile",
            'fono_movil' => 226589456,
            'prevision' => "FONOSA",
            'afp' => "SURA",
            'img_perfil' => "",
            'tipo_contrato' => "Plazo Fijo",
            'ingreso_contrato' => "2014-01-02 07:31:40",
            'vencimiento_contrato' => "2014-12-31 23:59:59",
            'cargo' => 2,
            'centro_costo' => 1,
            'active' => 1
        ));
    }
}