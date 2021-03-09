<?php
$titolo_pagina = "Gestione utenti";
$link_attivo = 'utenti';
ob_start();
//la funzione ob_start cattura l'output anziché mandarlo al browser
?>
<h1>Gestione utenti</h1>
<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eaque dicta expedita vel perspiciatis obcaecati iusto eos mollitia ratione dolor, consequuntur repudiandae. Labore odit impedit optio, neque maiores laudantium debitis excepturi!</p>
<?php
//la funzione ob_get_clean recupera l'output catturato e lo restituisce a una variabile.
$contenuto = ob_get_clean();
require(__DIR__ . '/../template/pagina.php');
?>