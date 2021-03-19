<?php
require_once __DIR__ . '/../include/main.php';

/*
la variabile di sistema $_SERVER['PATH_INFO'] contiene l'eventuale path che si trova dopo il nome della pagina web
esempio: se richiamo come url index.php/foo/bar, la variabile conterrà /foo/bar.

*/


if (isset($_SERVER['PATH_INFO'])) {
    $pathinfo = $_SERVER['PATH_INFO'];
    $segmenti = explode('/', $pathinfo);
    //rimuovo il primo elemento dell'array (il quale è vuoto)
    array_shift($segmenti);
    if (is_array($segmenti) && count($segmenti >= 2)) {
        $controller = $segmenti[0];
        $task = $segmenti[1];
    }
} else {
    $controller = filter_input(INPUT_GET, 'controller', FILTER_SANITIZE_STRING);
    $task = filter_input(INPUT_GET, 'task', FILTER_SANITIZE_STRING);
}

if (file_exists("$controller.php")) {
    require_once __DIR__ . "/$controller.php";
    if (function_exists($task)) {
        $task();
    } else {
        throw new RuntimeException("Funzione $task del controller $controller non trovata");
    }
} else {
    throw new RuntimeException("controller $controller non trovato");
}
