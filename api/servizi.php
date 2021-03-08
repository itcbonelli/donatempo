<?php

function elencoServizi() {
    $dataset=[];
    //TODO: scrivere codice che esegue la query e popola l'array DataSet
    header("Content-type: application/json", true);
    echo json_encode($dataset);
    exit;
}