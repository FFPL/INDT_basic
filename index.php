<?php

require "./vendor/autoload.php";

use FFPL\Template;
use FFPL\Router;
use FFPL\Utils;

$tpl = new Template("./templates/body.tpl");
$routes = new Router();  

$routes->map("GET","/list",function($tpl){
    $tpl->addFile("content","./templates/content.tpl");
    //Display the lastest authors
    $authors = json_decode(file_get_contents("https://bibliapp.herokuapp.com/api/authors"));
    foreach($authors as $author){
        $tpl->aName = $author->firstName;
        $tpl->lName = $author->lastName;
        $tpl->count = json_decode(file_get_contents("https://bibliapp.herokuapp.com/api/authors/{$author->id}/books/count"))->count;
        $tpl->block("ROW");
    }
},"LIST");

$routes->map("POST","/",function($tpl){
    $tpl->addFile("content","./templates/content.tpl");
    $authorsURL = 'https://bibliapp.herokuapp.com/api/authors';
    $booksURL = 'https://bibliapp.herokuapp.com/api/books';
    $content = json_decode(file_get_contents($_FILES["file"]["tmp_name"]));
    $curl = function($url,$data){
        $data_string = json_encode($data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
        curl_setopt($ch, CURLOPT_CAINFO,"./cacert.pem");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
            'Content-Type: application/json',                                                                                
            'Content-Length: ' . strlen($data_string))                                                                       
        );                                                                                                                   
        return curl_exec($ch);
    };
    if(function_exists('curl_version')){
        $authors =0;
        $books =0;
        foreach($content->author as $author){
            $authorData = array("firstName"=>$author->firstName,"lastName"=>$author->lastName);
            $authorReturn = json_decode($curl($authorsURL,$authorData));
            if(is_numeric($authorReturn->id)){
                foreach($author->books as $book){
                    $bookData =array("title"=>$book->title,"authorId"=>$authorReturn->id);
                    $bookReturn = json_decode($curl($booksURL,$bookData));
                    $books++;
                }
            }
            $authors++;
        }
        $tpl->content = "
                <div class='container'>
                    <div class='row mt'>
                        <h4>
                            Imported {$authors} authors and {$books} books. Go to the <a href='/list'>list</a>
                        </h4>
                    </div>
                </div>";
    }else{
        $tpl->content = "
                <div class='container'>
                    <div class='row mt'>
                        <h3>
                            ERROR: cURL extension not installed
                        </h3>
                    </div>
                </div>";

    }

},"UPLOAD");

$routes->map("GET","/",function($tpl){
    //Only the index
    $tpl->addFile("content","./templates/no-content.tpl");
},"INDEX");

$request = $routes -> match();

if($request){
    $do = $request["target"];
    switch($request["name"]){
        case 'INDEX':
            $do($tpl);
        break;
        case 'UPLOAD':
            $do($tpl);
        break;
        case 'LIST':
            $do($tpl);
        break;
    }
}else{
    $tpl->addFile("content","./templates/404.tpl");
}

$tpl->show();
