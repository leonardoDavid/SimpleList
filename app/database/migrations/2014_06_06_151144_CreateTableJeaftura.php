<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableJeaftura extends Migration {

	/**
	 * Crea la tabla jefatura, encargada de almacenar las jefaturas, es decir
	 * los usuarios que tienen login en el sistema
	 */
	public function up(){
		Schema::create('jefatura',function($tabla){
			$tabla->increments('id')->unique();
			$tabla->string('username',80);
			$tabla->string('password',200);
			$tabla->string('remember_token');
			$tabla->string('id_empleado',10);
			$tabla->boolean('active');
			$tabla->dateTime('created_at')->default('0000-00-00 00:00:00');
			$tabla->dateTime('updated_at')->default('0000-00-00 00:00:00');
		});
	}

	/**
	 * Elimina la tabla jefatura
	 *
	 */
	public function down(){
		Schema::dropIfExists('jefatura');
	}

}
