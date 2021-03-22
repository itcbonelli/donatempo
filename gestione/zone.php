<?php
$titolo_pagina = "Gestione zone";
$link_attivo = 'zone';
ob_start();
//la funzione ob_start cattura l'output anziché mandarlo al browser
?>
<h1>Modifica zona</h1>
<?php
//la funzione ob_get_clean recupera l'output catturato e lo restituisce a una variabile.
$contenuto = ob_get_clean();
require(__DIR__ . '/template/pagina.php');
?>