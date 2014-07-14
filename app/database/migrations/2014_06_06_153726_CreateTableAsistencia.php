<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAsistencia extends Migration {

	/**
	 * Crea la tabla asistencia, encargada de almacenar la asistencia 
	 * de los empleados de la empresa
	 */
	public function up(){
		Schema::create('asistencia',function($tabla){
			$tabla->increments('id')->unique();
			$tabla->string('id_empleado',10);
			$tabla->text('comentario');
			$tabla->boolean('active');
			$tabla->dateTime('created_at')->default('0000-00-00 00:00:00');
			$tabla->dateTime('updated_at')->default('0000-00-00 00:00:00');
		});
	}

	/**
	 * Elimina la tabla asistencia
	 *
	 */
	public function down(){
		Schema::dropIfExists('asistencia');
	}

}
