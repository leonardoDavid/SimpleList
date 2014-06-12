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
            'prevision' => "Ni idea que es esto",
            'img_perfil' => "/img/profile/grumpy.jpg",
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
            'prevision' => "Ni idea que es esto 2.0",
            'img_perfil' => "",
            'cargo' => 2,
            'centro_costo' => 1,
            'active' => 1
        ));
    }
}