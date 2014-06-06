<?php

/**
* Se crean Centros de Costo de prueba
*/
class CentroCostoSeeder extends Seeder {
    public function run(){
    	CentroCosto::create(array(
    		'nombre' => "Centro de Pruebas",
            'active' => 1
        ));
    }
}