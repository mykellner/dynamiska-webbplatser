<?php

function initDatabase () {

try {
    return new PDO('mysql:host=127.0.0.1;dbname=myFace', 'root', '');
    
    echo "Connected to DB";
    
    } catch(PDOException $e){
        var_dump($e); 
    }

}