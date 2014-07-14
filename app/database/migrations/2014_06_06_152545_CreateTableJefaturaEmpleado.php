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
			$tabla->string('id_jefatura',10);
			$tabla->string('id_empleado',10);
			$tabla->dateTime('created_at')->default('0000-00-00 00:00:00');
			$tabla->dateTime('updated_at')->default('0000-00-00 00:00:00');
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
