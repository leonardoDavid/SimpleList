<?php

use SimpleList\Repositories\JefaturaRepo;
use SimpleList\Repositories\CentroRepo;
use SimpleList\Repositories\EmpleadoRepo;
use SimpleList\Repositories\AdelantoRepo;

class SiteController extends BaseController{
	/*
	|--------------------------------------------------------------------------
	| Funciones Router
	|--------------------------------------------------------------------------
	|
	| Estas funciones son llamadas directamente desde el controlador para 
	| realizar la carga dinamica del sistema.
	|
	*/
	public function getDashboard(){
		$user = JefaturaRepo::getUserData(Auth::user()->id);
		$fastInfo = $this->_getFastInfo();

		return View::make('pages.dashboard',array(
			'titlePage' => "Dashboard",
			'description' => "Centro de Control",
			'route' => Util::getTracert(),
			'menu' => Util::getMenu($user['name'],$user['img']),
			'user' => JefaturaRepo::getUserNotification($user),
			'pays' => $fastInfo['pays'],
			'porcent' => $fastInfo['porcent'],
			'employed' => $fastInfo['employed'],
			'centers' => $fastInfo['centers'],
			'page' => "This is a content"
		));
	}

	private function _getFastInfo(){
		$centers = CentroRepo::count();
		$employes = EmpleadoRepo::count();
		$pays = AdelantoRepo::sum();
		return array(
			'pays' => $pays,
			'porcent' => 1,
			'employed' => $employes,
			'centers' => $centers
		);
	}

}
