<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMenu extends Migration {
	/**
	 * Crea la tabla menu que contiene los items o menus
	 * del sistema
	 *
	 * @return void
	 */
	public function up(){
		Schema::create('menu',function($tabla){
			$tabla->increments('id')->unique();
			$tabla->string('name');
			$tabla->string('url');
			$tabla->string('icon');
			$tabla->integer('active');
			$tabla->timestamps();
		});
	}

	/**
	 * Elimina la tabla menu
	 *
	 * @return void
	 */
	public function down(){
		Schema::dropIfExists('menu');
	}

}
