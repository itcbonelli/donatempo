<?php
$titolo_pagina = "Stati di avanzamento richiesta";
$link_attivo = 'stati-avanzamento';
ob_start();
//la funzione ob_start cattura l'output anziché mandarlo al browser
?>
<h1>Elenco stati di avanzamento</h1>
<?php
//la funzione ob_get_clean recupera l'output catturato e lo restituisce a una variabile.
$contenuto = ob_get_clean();
require(__DIR__ . '/template/pagina.php');
?>