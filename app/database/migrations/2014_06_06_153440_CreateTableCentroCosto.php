<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCentroCosto extends Migration {

	/**
	 * Crea la tabla centro_costo, encargada de almacenar los centros de 
	 * costos de la empresa
	 */
	public function up(){
		Schema::create('centro_costo',function($tabla){
			$tabla->increments('id')->unique();
			$tabla->string('nombre',80);
			$tabla->boolean('active');
			$tabla->timestamps();
		});
	}

	/**
	 * Elimina la tabla centro_costo
	 *
	 */
	public function down(){
		Schema::dropIfExists('centro_costo');
	}

}
