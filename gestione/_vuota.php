<?php

require_once __DIR__ . '/../include/main.php';

$titolo_pagina = "Cruscotto";
$link_attivo = 'dashboard';
ob_start();
?>

<?php
$contenuto = ob_get_clean();
require(__DIR__ . '/template/pagina.php');
?>