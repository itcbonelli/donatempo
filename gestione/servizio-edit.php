<?php
$titolo_pagina = "Modifica servizio";
$link_attivo = 'servizio-edit';
ob_start();
//la funzione ob_start cattura l'output anziché mandarlo al browser
?>
<h1>Modifica servizio</h1>
<?php
//la funzione ob_get_clean recupera l'output catturato e lo restituisce a una variabile.
$contenuto = ob_get_clean();
require(__DIR__ . '/template/pagina.php');
?>