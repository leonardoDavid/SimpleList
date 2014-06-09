<?php

/**
* Se crea una jefatura, que es quien tendra login
*/
class JefaturaSeeder extends Seeder {
    public function run(){      
        //Para un Admin  
    	Jefatura::create(array(
    		'username' => "admin",
            'password' => Hash::make('test'),
            'remember_token' => "Future Token",
			'id_empleado' => '11111111-1',
            'active' => 1
        ));
    }
}