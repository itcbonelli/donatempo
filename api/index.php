<?php

use itcbonelli\donatempo\AiutoInput;

require_once __DIR__ . '/../include/main.php';

/*
la variabile di sistema $_SERVER['PATH_INFO'] contiene l'eventuale path che si trova dopo il nome della pagina web
esempio: se richiamo come url index.php/foo/bar, la variabile conterrà /foo/bar.

*/


if (isset($_SERVER['PATH_INFO'])) {
    $pathinfo = $_SERVER['PATH_INFO'];
    $segmenti = explode('/', $pathinfo);
    //rimuovo il primo elemento dell'array (il quale è vuoto)
    if (count($segmenti) >= 2) {
        $controller = $segmenti[1];
        $task = $segmenti[2];
    }
} else {
    $controller = AiutoInput::leggiStringa('controller', '');
    $task = AiutoInput::leggiStringa('task', 'index');
}

if (!empty($controller) && file_exists("$controller.php")) {
    require_once __DIR__ . "/$controller.php";
    if (function_exists($task)) {
        $task();
    } else {
        throw new RuntimeException("Funzione $task del controller $controller non trovata");
    }
} else {
    throw new RuntimeException("controller $controller non trovato");
}
