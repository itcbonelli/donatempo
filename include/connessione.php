<?php
require_once __DIR__ . '/config.php';

session_start();

$connstr=sprintf("mysql:host=%s:%d;dbname=%s;charset=%s", DB_HOST, DB_PORT, DB_NAME, DB_CHARSET);
$dbconn = new PDO($connstr, DB_USER, DB_PASSWORD);