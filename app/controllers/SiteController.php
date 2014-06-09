<?php

class SiteController extends BaseController {

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
		$user = Util::getUserData(Auth::user()->id);
		$fastInfo = $this->_getFastInfo();

		return View::make('pages.dashboard',array(
			'titlePage' => "Dashboard",
			'description' => "Centro de Control",
			'route' => Util::getTracert(),
			'user' => Util::getUserNotification($user),
			'menu' => Util::getMenu($user['name'],$user['img']),
			'pays' => $fastInfo['pays'],
			'porcent' => $fastInfo['porcent'],
			'employed' => $fastInfo['employed'],
			'centers' => $fastInfo['centers'],
			'page' => "This is a content"
		));
	}

	private function _getFastInfo(){

		$centers = CentroCosto::where('active','=','1')->count();
		$employes = Empleado::where('active','=','1')->count();
		$pays = Adelanto::where('active','=','1')->sum('monto');

		return array(
			'pays' => $pays,
			'porcent' => 1,
			'employed' => $employes,
			'centers' => $centers
		);
	}

}
