<?php

use itcbonelli\donatempo\tabelle\Associazione;

function elencoAssociazioni()
{
    $dataset = Associazione::elencoAssociazioni();
    header("Content-type: application/json", true);
    echo json_encode($dataset);
    exit;
}

function salvaAssociazione() {
    //TODO: implementare politica di sicurezza
}

function creaAssociazione() {
    //TODO: implementare politica di sicurezza
}

function eliminaAssociazione() {
    //TODO: implementare politica di sicurezza
}