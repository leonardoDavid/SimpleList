<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAdelanto extends Migration {

	/**
	 * Crea la tabla adelanto, encargada de almacenar los adelantos 
	 * que se le dan a los empleados
	 */
	public function up(){
		Schema::create('adelanto',function($tabla){
			$tabla->increments('id')->unique();
			$tabla->integer('monto');
			$tabla->integer('id_empleado');
			$tabla->boolean('active');
			$tabla->timestamps();
		});
	}

	/**
	 * Elimina la tabla adelanto
	 *
	 */
	public function down(){
		Schema::dropIfExists('adelanto');
	}

}
