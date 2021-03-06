<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCargo extends Migration {

	/**
	 * Crea la tabla cargo, encargada de almacenar los cargos de la empresa
	 */
	public function up(){
		Schema::create('cargo',function($tabla){
			$tabla->increments('id')->unique();
			$tabla->string('nombre',80);
			$tabla->float('valor_dia')->unsigned();
			$tabla->boolean('active');
			$tabla->dateTime('created_at')->default('0000-00-00 00:00:00');
			$tabla->dateTime('updated_at')->default('0000-00-00 00:00:00');
		});
	}

	/**
	 * Elimina la tabla cargo
	 *
	 */
	public function down(){
		Schema::dropIfExists('cargo');
	}

}
