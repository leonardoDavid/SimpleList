<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Jefatura extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'jefatura';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	public function scopeGetUserData($query,$id){
		return $query->join('empleado','empleado.id','=','jefatura.id_empleado')
					 ->select('empleado.img_perfil as img','empleado.nombre as name','empleado.ape_paterno as paterno','empleado.ape_materno as materno','empleado.created_at as added');
	}

	public function menus(){
        return $this->belongsToMany('MainMenu', 'permisos_menu', 'user_id', 'menu_id')->where('menu.active','=','1')->orderBy('menu.id');
    }

}
