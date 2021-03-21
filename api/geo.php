<?php

use itcbonelli\donatempo\AiutoInput;
use itcbonelli\donatempo\tabelle\Comune;
use itcbonelli\donatempo\tabelle\Provincia;

function elencoComuni()
{
    $provincia = AiutoInput::leggiStringa('provincia', null);
    $dataset = Comune::getElencoComuni($provincia);
    header('Cache-Control: max-age=86400');
    header("Content-type: application/json", true);
    echo json_encode($dataset, JSON_PRETTY_PRINT);
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
    $dataset = [];
    //TODO: scrivere codice che esegue la query e popola l'array DataSet
    header("Content-type: application/json", true);
    echo json_encode($dataset, JSON_PRETTY_PRINT);
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
    $lat = AiutoInput::leggiFloat('lat');
    $long = AiutoInput::leggiFloat('long');
}
