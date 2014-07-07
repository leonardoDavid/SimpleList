<?php

use SimpleList\Entities\Cargo;

/**
* Se crean cargos de prueba
*/
class CargoSeeder extends Seeder {
    public function run(){
    	Cargo::create(array(
    		'nombre' => "Maestro Pintor",
            'valor_dia' => 1.2,
            'active' => 1
        ));

        Cargo::create(array(
            'nombre' => "Jornal",
            'valor_dia' => 0.8,
            'active' => 1
        ));

        Cargo::create(array(
            'nombre' => "Carpintero",
            'valor_dia' => 0.8,
            'active' => 1
        ));
    }
}