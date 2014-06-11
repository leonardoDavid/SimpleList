<?php

class Util{

	/*
    |--------------------------------------------------------------------------
    | Funciones Comunes
    |--------------------------------------------------------------------------
    |
    | Estas funciones son reutilizables por todos los metodos del controlador,
    | aqui caben funciones como obtener el menu de cierto usuario, obtener la
    | la ruta actual donde se encuentra, entre otros.
    |
    */
    public static function getUserData($id){
        $user = Jefatura::getUserData($id)->get();
        return array(
            'name' => $user[0]->name,
            'fullname' => $user[0]->name." ".$user[0]->paterno,
            'added' => $user[0]->added,
            'img' => $user[0]->img
        );
    }

    public static function getMenu($name,$img){
        $response = "";

        $items = Jefatura::find(Auth::user()->id)->menus;
        foreach ($items as $item){
            $submenu = SubMainMenu::where('menu_id','=',$item->id)
                                  ->where('active','=','1')
                                  ->get()->toArray();
            $active = (Request::path() == $item->url) ? "active" : " ";

            if(count($submenu) > 0){
                $submenus = "";
                foreach ($submenu as $row) {
                    $submenus .= "<li><a href='".$row['url']."'><i class='fa fa-angle-double-right'></i> ".$row['name']."</a></li>";
                }
                $response .= View::make('menus.ItemMulti',array(
                    'class' => $active,
                    'text' => $item->name,
                    'icon' => $item->icon,
                    'list' => $submenus
                ));
            }
            else{
                $response .= View::make('menus.ItemSimple',array(
                    'url' => $item->url,
                    'icon' => $item->icon,
                    'text' => $item->name,
                    'class' => $active
                ));
            }

        }
        return View::make('menus.menu',array(
            'menu' => $response,
            'name' => $name,
            'img' => $img
        ));
    }

    public static function getTracert(){
        $urls = explode("/", Request::path());
        if( $urls[0] != "" && count($urls) > 0 ){
            $links = '<li><a href="/"><i class="fa fa-dashboard"></i> Dashboard</a></li>';
            $linker = "/";
            foreach ($urls as $url) {
                if($url != ""){
                    $linker .= $url."/";
                    $links .= '<li><a href="'.$linker.'">'.ucwords($url).'</a></li>';
                }
            }
            return $links;
        }
        else
            return '<li><a href="/"><i class="fa fa-dashboard active"></i> Dashboard</a></li>';
    }

    public static function getUserNotification($userInfo){
        return View::make('menus.userNotification',array(
            'username' => $userInfo['name'],
            'fullname' => $userInfo['fullname'],
            'added' => $userInfo['added'],
            'img' => $userInfo['img']
        ));
    }

    public static function getSelectCargos(){
        $options = "<option value='0'>Seleccione un Cargo</option>";
        $cargos = Cargo::where('active','=','1')->get();
        foreach ($cargos as $row){
            $options .= "<option value='".$row->id."'>".$row->nombre."</option>";
        }
        return $options;
    }

    public static function getSelectCenters(){
        $options = "<option value='0'>Seleccione un Centro</option>";
        $centers = CentroCosto::where('active','=','1')->get();
        foreach ($centers as $row){
            $options .= "<option value='".$row->id."'>".$row->nombre."</option>";
        }
        return $options;
    }

}