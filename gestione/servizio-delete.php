<?php
require_once __DIR__ . '/../include/main.php';
$titolo_pagina = "Elimina servizio - Gestione Donatempo";
$link_attivo = 'servizio-delete';
ob_start();
//la funzione ob_start cattura l'output anziché mandarlo al browser
?>
<h1>Elimina servizio</h1>
<?php
//la funzione ob_get_clean recupera l'output catturato e lo restituisce a una variabile.
$contenuto = ob_get_clean();
require(__DIR__ . '/template/pagina.php');
?>