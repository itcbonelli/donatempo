<?php

use itcbonelli\donatempo\AiutoInput;

require_once __DIR__ . '/../include/main.php';

$segmenti = [];
$modulo = '';
$funzione = '';

/*
la variabile di sistema $_SERVER['PATH_INFO'] contiene l'eventuale path che si trova dopo il nome della pagina web
esempio: se richiamo come url index.php/foo/bar, la variabile conterrà /foo/bar.
*/

if (isset($_SERVER['PATH_INFO'])) {
    $pathinfo = $_SERVER['PATH_INFO'];
    //rimuovo il primo slash che rompe le palle
    $pathinfo = substr($pathinfo, 1);
    //divido la stringa in corrispondenza degli slash per ricavare i segmenti di URL
    $segmenti = explode('/', $pathinfo);

    if (isset($segmenti[0]) && !empty($segmenti[0])) {
        $modulo = $segmenti[0];
    } else {
        //il codice http 400 indica che la richiesta non è stata formulata correttamente
        http_response_code(400);
        throw new Exception("Richiesta non correttamente formulata");
    }


    if (isset($segmenti[1]) && !empty($segmenti[1])) {
        $funzione = $segmenti[1];
    } else {
        $funzione = 'index';
    }
}

if (!empty($modulo) && file_exists("$modulo.php")) {
    require_once __DIR__ . "/$modulo.php";
    if (function_exists($funzione)) {
        $funzione();
    } else {
        throw new RuntimeException("Funzione $funzione del modulo $modulo non trovata");
    }
} else {
    //il modulo non esiste
    http_response_code(404);
    throw new RuntimeException("modulo $modulo non trovato");
}
