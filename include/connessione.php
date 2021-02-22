<?php
require_once __DIR__ . '/config.php';

session_start();

$connstr=sprintf("mysql:host=%s:%d;dbname=%s;charset=%s", DB_HOST, DB_PORT, DB_CHARSET);
$dbconn = new PDO($connstr, DB_USER, DB_PASSWORD);

if(DEBUG) {
    ini_set('display_errors', 1);
    ini_set('error_reporting', E_ALL);
    
    $dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}