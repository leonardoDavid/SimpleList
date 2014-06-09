<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEmpleado extends Migration {

	/**
	 * Crea la tabla empleado, encargada de almacenar los empleados de la empresa
	 */
	public function up(){
		Schema::create('empleado',function($tabla){
			$tabla->string('id',10)->unique();
			$tabla->string('nombre',80);
			$tabla->string('ape_paterno',200);
			$tabla->string('ape_materno',200)->nullable();
			$tabla->text('direccion');
			$tabla->integer('fono_fijo')->nullable();
			$tabla->integer('fono_movil');
			$tabla->string('prevision');
			$tabla->string('img_perfil');
			//Campos que sirver de relaciones
			$tabla->integer('cargo');
			$tabla->integer('centro_costo');
			$tabla->boolean('active');
			$tabla->timestamps();
		});
	}

	/**
	 * Elimina la tabla empleado
	 *
	 */
	public function down(){
		Schema::dropIfExists('empleado');
	}

}
