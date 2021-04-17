<?php

use itcbonelli\donatempo\AiutoApi;
use itcbonelli\donatempo\AiutoInput;
use itcbonelli\donatempo\tabelle\Disponibilita;

function elencoDisponibilita()
{
}

function getDisponibilita()
{
    $id_disponibilita = AiutoInput::leggiIntero('id_disponibilita', -1, 'G');
    if ($id_disponibilita == -1) {
        AiutoApi::inviaJSON(['errore' => 'Parametro id_disponibilita non fornito'], 400);
    }
    $disp = new Disponibilita();
    if ($disp->carica($id_disponibilita)) {
        AiutoApi::inviaJSON($disp);
    } else {
        AiutoApi::inviaJSON(['errore' => 'Record non trovato'], 400);
    }
}

function putDisponibilita()
{
}

function deleteDisponibilita()
{
}
