<?php

require "./vendor/autoload.php";

use FFPL\Template;
use FFPL\Router;

$tpl = new Template("./templates/body.tpl");
$routes = new Router();  

$routes->map("GET","/list",function(){

},"LIST");

$routes->map("GET","/",function($tpl){
    $tpl->addFile("content","./templates/no-content.tpl");
    
},"INDEX");

$request = $routes -> match();

if($request){
    $do = $request["target"];
    switch($request["name"]){
        case 'INDEX':
            $do($tpl);
        break;
    }
}else{
    $tpl->addFile("content","./template/404.tpl");
}


$tpl->show();
