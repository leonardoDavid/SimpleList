<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableJefaturaEmpleado extends Migration {

	/**
	 * Crea la tabla jefatura_empleado, encargada de almacenar los empleados
	 * de cierta jefatura
	 */
	public function up(){
		Schema::create('jefatura_empleado',function($tabla){
			$tabla->increments('id')->unique();
			$tabla->integer('id_jefatura');
			$tabla->integer('id_empleado');
			$tabla->timestamps();
		});
	}

	/**
	 * Elimina la tabla jefatura_empleado
	 *
	 */
	public function down(){
		Schema::dropIfExists('jefatura_empleado');
	}

}
