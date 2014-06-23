<?php

/*
|--------------------------------------------------------------------------
| Rutas de Login/Logout
|--------------------------------------------------------------------------
|
| Rutas que permiten realizar el inicio y cierre de sesión
|
*/
Route::get('login', 'AuthController@showLogin');
Route::post('login', array('before' => 'csrf', 'uses' => 'AuthController@postLogin'));

/*
|--------------------------------------------------------------------------
| Rutas de Generale de Sitio
|--------------------------------------------------------------------------
|
| Rutas generales, todas con filtro de autenticacion, y otras generales 
| que piden filtros de autorizacion de contenido
|
*/
Route::group(array('before' => 'auth'), function(){
	//Administrador de Empleados
	Route::get('/admin',function(){
		return Redirect::to('/admin/empleados');
	});
	Route::get('/admin/empleados', 'AdminController@getEmpleados');
	Route::post('/admin/empleados/add','AdminController@addEmployed');
	Route::post('/admin/empleados/refresh','AdminController@refreshEmployed');
	Route::post('/admin/empleados/enabled','AdminController@enabledEmployed');
	Route::post('/admin/empleados/disabled','AdminController@disabledEmployed');
	
	//Administrador de Centros de Costo
	Route::get('/admin/centros', 'AdminController@getCentros');
	Route::post('/admin/centros/add','AdminController@addCenter');
	Route::post('/admin/centros/refresh','AdminController@refreshCenter');
	Route::post('/admin/centros/enabled','AdminController@enabledCenter');
	Route::post('/admin/centros/disabled','AdminController@disabledCenter');

	//Asistencia
	Route::get('/asistencia',function(){
		return Redirect::to('/asistencia/tomar');
	});
	Route::get('/asistencia/tomar', 'AsistenciaController@getTake');
	Route::post('/asistencia/tomar', 'AsistenciaController@getListAssistance');
	Route::post('/asistencia/tomar/save', 'AsistenciaController@saveAssistance');
	Route::post('/asistencia/tomar/update', 'AsistenciaController@updateAssistance');
	Route::get('/asistencia/reportes', 'ReportesController@showFilterAssistance');
	Route::post('/asistencia/reportes/generatecsv', 'ReportesController@exportCSVFile');

	//Rutas Varias
	Route::get('/', 'SiteController@getDashboard');
	Route::get('/perfil','ProfileController@getProfile');
	Route::get('logout', 'AuthController@logOut');
});

/*
|--------------------------------------------------------------------------
| Rutas con filtros de Acceso
|--------------------------------------------------------------------------
|
| Estas rutas se verifica primero que el usuario quien se logeo tenga
| prmisos para poder ver la ruta que esta solicitando
|
*/
Route::when('/','access');
Route::when('admin','access:/admin');
Route::when('admin/*','access:/admin');
Route::when('asistencia','access:/asistencia');
Route::when('asistencia/*','access:/asistencia');
Route::when('adelantos','access:/adelantos');
Route::when('adelantos/*','access:/adelantos');

/*
|--------------------------------------------------------------------------
| Listener
|--------------------------------------------------------------------------
|
| Esta seccion se encuentra a la escucha de eventos en la aplicacion, como 
| por ejemplo imprimir cada query en ejecucion.
| Solo se ejecutan si el debbuger se encuentra en true
|
*/
$debbuger = false;
if($debbuger){
	Event::listen('illuminate.query', function($query){
		echo "<pre>";
	    var_dump($query);
	    echo "</pre>";
	});
}