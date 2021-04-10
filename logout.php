<?php

use itcbonelli\donatempo\tabelle\Utente;

require_once __DIR__ . '/include/main.php';
Utente::Logout();
header('location:index.php');
exit;
