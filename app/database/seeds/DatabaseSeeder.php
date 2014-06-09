<?php

class DatabaseSeeder extends Seeder{

	/**
	 * Correr todos los seeders indicados para poblar la DB
	 *
	 * @return void
	 */
	public function run(){
		Eloquent::unguard();
		$this->call('EmpleadosSeeder');
		$this->call('CargoSeeder');
		$this->call('CentroCostoSeeder');
		$this->call('JefaturaSeeder');
		$this->call('MenuTableSeeder');
		$this->call('SubMainTableSeeder');
	}
}
