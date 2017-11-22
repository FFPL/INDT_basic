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

    $content = @file_get_contents($_FILES["file"]["tmp_name"]);
    $test = (is_string($content) && is_array(json_decode($content, true)) && (json_last_error() == JSON_ERROR_NONE)) ? true : false; //Tests if the file is a valid JSON(very basic verification)

    if($test){ 
        $content = json_decode($content);
        if(function_exists('curl_version')){
            // cURL function to POST data
            $curl = function($url,$data){
                $data_string = json_encode($data);
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
                curl_setopt($ch, CURLOPT_CAINFO,"./cacert.pem");    //Included certificate validator
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
                    'Content-Type: application/json',                                                                                
                    'Content-Length: ' . strlen($data_string))                                                                       
                );                                                                                                                   
                return curl_exec($ch);
            };
            $authors=0;
            $books=0;
            if(is_object($content) && !empty($content->author)){
                foreach($content->author as $author){
                    $authorData = array("firstName"=>$author->firstName,"lastName"=>$author->lastName);
                    $authorReturn = json_decode($curl($authorsURL,$authorData));
                    if(is_numeric($authorReturn->id)){ 
                        foreach($author->books as $book){
                            $bookData =array("title"=>$book->title,"authorId"=>$authorReturn->id);
                            $bookReturn = json_decode($curl($booksURL,$bookData));
                            if(is_numeric($bookReturn->id))
                                $books++;
                        }
                    }else{
                        $tpl->addFile("content","./templates/errors.tpl");
                        $tpl->block("VALID");
                        break;
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
                    $tpl->addFile("content","./templates/errors.tpl");
                    $tpl->block("EMPTY");
            }
        }else{
            $tpl->addFile("content","./templates/errors.tpl");
            $tpl->block("CURL");
        }
    }else{
        $tpl->addFile("content","./templates/errors.tpl");
        $tpl->block("VALID");
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