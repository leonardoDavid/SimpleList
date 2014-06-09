<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSubMenu extends Migration {
	/**
	 * Crea la tabla SubMenu que contiene los items o submenus
	 * del sistema
	 *
	 * @return void
	 */
	public function up(){
		Schema::create('submenu',function($tabla){
			$tabla->increments('id')->unique();
			$tabla->string('name');
			$tabla->string('url');
			$tabla->string('icon');
			$tabla->integer('menu_id');
			$tabla->integer('active');
			$tabla->timestamps();
		});
	}

	/**
	 * Elimina la tabla submenu
	 *
	 * @return void
	 */
	public function down(){
		Schema::dropIfExists('submenu');
	}

}
