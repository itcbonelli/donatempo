<?php

use itcbonelli\donatempo\tabelle\Servizio;

function elencoServizi() {
    $dataset=Servizio::elencoServizi();
    header("Content-type: application/json", true);
    echo json_encode($dataset, JSON_PRETTY_PRINT);
    exit;
}