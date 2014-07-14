<?php

use SimpleList\Entities\SubMainMenu;

class SubMainTableSeeder extends Seeder{
	public function run(){
        SubMainMenu::create(array(
            'name' => "Empleados",
            'url' => "/admin/empleados",
            'icon' => "",
            'menu_id' => 2,
            'active' => 1
        ));
        SubMainMenu::create(array(
            'name' => "Centro de Costos",
            'url' => "/admin/centros",
            'icon' => "",
            'menu_id' => 2,
			'active' => 1
        ));
        SubMainMenu::create(array(
            'name' => "Cargos",
            'url' => "/admin/cargos",
            'icon' => "",
            'menu_id' => 2,
            'active' => 1
        ));
        SubMainMenu::create(array(
            'name' => "Jefaturas",
            'url' => "/admin/jefaturas",
            'icon' => "",
            'menu_id' => 2,
            'active' => 1
        ));
        SubMainMenu::create(array(
            'name' => "Tomar Asistencia",
            'url' => "/asistencia/tomar",
            'icon' => "",
            'menu_id' => 3,
            'active' => 1
        ));
        SubMainMenu::create(array(
            'name' => "Reportes",
            'url' => "/asistencia/reportes",
            'icon' => "",
            'menu_id' => 3,
            'active' => 1
        ));
        SubMainMenu::create(array(
            'name' => "Ingresar Adelanto",
            'url' => "/adelantos/ingresar",
            'icon' => "",
            'menu_id' => 4,
            'active' => 1
        ));
        SubMainMenu::create(array(
            'name' => "Reportes",
            'url' => "/adelantos/reportes",
            'icon' => "",
            'menu_id' => 4,
            'active' => 1
        ));
    }
}