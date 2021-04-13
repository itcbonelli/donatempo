<?php

use itcbonelli\donatempo\AiutoInput;
use itcbonelli\donatempo\RispostaApi;
use itcbonelli\donatempo\tabelle\Associazione;

function elencoAssociazioni()
{
    $dataset = Associazione::elencoAssociazioni();
    header("Content-type: application/json", true);
    echo json_encode($dataset);
    exit;
}

function getAssociazione() {
    $id=AiutoInput::leggiIntero('id', 0, "G");
    $associazione=new Associazione();
    $carica=$associazione->carica($id);
    if($carica) {
        header("Content-type: application/json", true);
        echo json_encode($associazione, JSON_PRETTY_PRINT);
    } else {
        http_response_code(404);
        
    }
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