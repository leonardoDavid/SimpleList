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
			$tabla->integer('monto')->unsigned();
			$tabla->string('id_empleado',10);
			$tabla->boolean('active');
			$tabla->dateTime('created_at')->default('0000-00-00 00:00:00');
			$tabla->dateTime('updated_at')->default('0000-00-00 00:00:00');
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
