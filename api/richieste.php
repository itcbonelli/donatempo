<?php

use itcbonelli\donatempo\AiutoApi;
use itcbonelli\donatempo\filtri\FiltroRichieste;
use itcbonelli\donatempo\tabelle\Richiesta;
use itcbonelli\donatempo\tabelle\Utente;

function elencoRichiesteVolontario() {
    $io = Utente::getMioUtente();
    if($io->volontario==false) {
        AiutoApi::inviaJSON(false, AiutoApi::STATO_HTTP_NON_AUTORIZZATO);
        exit;
    }
    $filtro = new FiltroRichieste();
    $filtro->id_volontario = $io->id_utente;
    $richieste = Richiesta::ElencoRichieste($filtro);
    AiutoApi::inviaJSON($richieste);
}

function elencoRichiesteUtente() {
    
}

function putRichiesta() {

}

function aggiornaStatoRichiesta() {

}

function assegnaRichiesta() {

}