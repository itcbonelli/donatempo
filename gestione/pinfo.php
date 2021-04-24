<?php
require_once __DIR__ . '/../include/main.php';
$titolo_pagina = "Informazioni di sistema  - Gestione Donatempo";
$link_attivo = 'pinfo';
ob_start();
?>

<?php
phpinfo();
//la funzione ob_get_clean recupera l'output catturato e lo restituisce a una variabile.
$contenuto = ob_get_clean();
require(__DIR__ . '/template/pagina.php');
?>