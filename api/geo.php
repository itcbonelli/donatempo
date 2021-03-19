<?php

use itcbonelli\donatempo\AiutoInput;
use itcbonelli\donatempo\tabelle\Comune;
use itcbonelli\donatempo\tabelle\Provincia;

function elencoComuni()
{
    $dataset = Comune::getElencoComuni('cn');
    header("Content-type: application/json", true);
    echo json_encode($dataset);
    exit;
}

function elencoProvince()
{
    $dataset = Provincia::caricaTutte();
    header("Content-type: application/json", true);
    echo json_encode($dataset);
    exit;
}

function elencoRegioni()
{
    $dataset = [];
    //TODO: scrivere codice che esegue la query e popola l'array DataSet
    header("Content-type: application/json", true);
    echo json_encode($dataset);
    exit;
}

function elencoAree()
{
    $dataset = [];
    //TODO: scrivere codice che esegue la query e popola l'array DataSet
    header("Content-type: application/json", true);
    echo json_encode($dataset);
    exit;
}

function localizza()
{
    $lat = AiutoInput::leggiFloat('lat');
    $long = AiutoInput::leggiFloat('long');
    
}
