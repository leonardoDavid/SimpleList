<?php namespace SimpleList\Libraries;

use SimpleList\Entities\Jefatura;
use SimpleList\Entities\CentroCosto;
use SimpleList\Entities\SubMainMenu;
use SimpleList\Entities\Cargo;
use SimpleList\Entities\Empleado;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\View;

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

}