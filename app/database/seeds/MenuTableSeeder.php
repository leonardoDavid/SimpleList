<?php

use SimpleList\Entities\MainMenu;

/**
* Agregamos los menus que tambien sirven como acciones/permisos
*/
class MenuTableSeeder extends Seeder{
    public function run(){
        MainMenu::create(array(
            'name' => "Dashboard",
            'url' => "/",
            'icon' => "fa-dashboard",
            'active' => 1
        ));
        MainMenu::create(array(
            'name' => "Administración",
            'url' => "/admin",
            'icon' => "fa-cogs",
			'active' => 1
        ));
        MainMenu::create(array(
            'name' => "Asistencia",
            'url' => "/asistencia",
            'icon' => "fa-check",
            'active' => 1
        ));
        MainMenu::create(array(
            'name' => "Adelantos",
            'url' => "/adelantos",
            'icon' => "fa-money",
            'active' => 1
        ));
    }
}