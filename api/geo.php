<?php

use itcbonelli\donatempo\AiutoApi;
use itcbonelli\donatempo\AiutoDB;
use itcbonelli\donatempo\AiutoInput;
use itcbonelli\donatempo\tabelle\Comune;
use itcbonelli\donatempo\tabelle\Profilo;
use itcbonelli\donatempo\tabelle\Provincia;
use itcbonelli\donatempo\tabelle\Utente;
use itcbonelli\donatempo\tabelle\Zona;

function elencoComuni()
{
    $provincia = AiutoInput::leggiStringa('provincia', '');
    $dataset = Comune::getElencoComuni($provincia);
    AiutoApi::inviaJSON($dataset, AiutoApi::STATO_HTTP_OK);
    exit;
}

function elencoProvince()
{
    $dataset = Provincia::caricaTutte();
    AiutoApi::inviaJSON($dataset, AiutoApi::STATO_HTTP_OK);
    exit;
}

function elencoRegioni()
{
    $dataset = Provincia::ElencoRegioni();
    AiutoApi::inviaJSON($dataset, AiutoApi::STATO_HTTP_OK);
    exit;
}

function elencoAree()
{
    $dataset = Zona::ElencoZone();
    AiutoApi::inviaJSON($dataset, AiutoApi::STATO_HTTP_OK);
}

function localizza()
{
    $lat = AiutoInput::leggiFloat('lat', null, 'P');
    $long = AiutoInput::leggiFloat('long', null, 'P');

    
    $utente = AiutoApi::autentica();
    if ($utente == false) {
        AiutoApi::inviaJSON([
            'risultato' => false,
            'errore' => 'Dati di accesso non validi'
        ]);
        return;
    }

    if ($lat == null || $long == null) {
        AiutoApi::inviaJSON([
            'risultato' => false,
            'errore' => 'Coordinate non valide'
        ]);
        return;
    }

    $profilo = new Profilo();
    $profilo->carica($utente->id_utente);
    $profilo->latitudine = $lat;
    $profilo->longitudine = $long;
    $salva = $profilo->salva();
    if ($salva) {
        AiutoApi::inviaJSON(['risultato' => true]);
        return;
    } else {
        AiutoApi::inviaJSON(['risultato' => false]);
        return;
    }
}
