<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/connessione.php';
require_once __DIR__ . '/../vendor/autoload.php';

//imposto i parametri di localizzazione per la lingua italiana
setlocale(LC_ALL, 'it_IT');

if(DEBUG) {
    ini_set('display_errors', 1);
    ini_set('error_reporting', E_ALL);
    
    $dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}