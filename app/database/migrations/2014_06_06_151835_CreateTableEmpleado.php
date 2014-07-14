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
			$tabla->integer('fono_fijo')->nullable()->unsigned();
			$tabla->integer('fono_movil')->unsigned();
			$tabla->string('prevision');
			$tabla->string('afp');
			$tabla->string('img_perfil');
			$tabla->enum('tipo_contrato', array('Plazo Fijo', 'Por Hora', 'Indefinido'));
			$tabla->dateTime('ingreso_contrato')->default('0000-00-00 00:00:00');
			$tabla->dateTime('vencimiento_contrato')->default('0000-00-00 00:00:00');
			//Campos que sirven de relaciones
			$tabla->integer('cargo');
			$tabla->integer('centro_costo');
			$tabla->boolean('active');
			$tabla->dateTime('created_at')->default('0000-00-00 00:00:00');
			$tabla->dateTime('updated_at')->default('0000-00-00 00:00:00');
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
