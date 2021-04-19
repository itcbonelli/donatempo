<?php

use itcbonelli\donatempo\AiutoApi;
use itcbonelli\donatempo\AiutoInput;
use itcbonelli\donatempo\tabelle\Comune;
use itcbonelli\donatempo\tabelle\Profilo;
use itcbonelli\donatempo\tabelle\Provincia;
use itcbonelli\donatempo\tabelle\Utente;

function elencoComuni()
{
    $provincia = AiutoInput::leggiStringa('provincia', '');
    $dataset = Comune::getElencoComuni($provincia);
    //intestazioni della risposta
    header('Cache-Control: max-age=86400');
    header("Content-type: application/json", true);
    //Corpo della risposta
    echo json_encode($dataset);
    exit;
}

function elencoProvince()
{
    $dataset = Provincia::caricaTutte();
    header('Cache-Control: max-age=86400');
    header("Content-type: application/json", true);
    echo json_encode($dataset, JSON_PRETTY_PRINT);
    exit;
}

function elencoRegioni()
{
    $dataset = Provincia::ElencoRegioni();
    //TODO: scrivere codice che esegue la query e popola l'array DataSet
    header("Content-type: application/json", true);

    echo json_encode(array_column($dataset, 'regione'), JSON_PRETTY_PRINT);
    exit;
}

function elencoAree()
{
    $dataset = [];
    //TODO: scrivere codice che esegue la query e popola l'array DataSet
    header("Content-type: application/json", true);
    echo json_encode($dataset, JSON_PRETTY_PRINT);
    exit;
}

function localizza()
{
    $lat = AiutoInput::leggiFloat('lat', null, 'P');
    $long = AiutoInput::leggiFloat('long', null, 'P');

    $username = AiutoInput::leggiStringa('username', 'P');
    $password = AiutoInput::leggiStringa('password', 'P');
    $utente = Utente::login($username, $password);
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
