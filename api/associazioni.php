<?php

use itcbonelli\donatempo\AiutoApi;
use itcbonelli\donatempo\AiutoInput;
use itcbonelli\donatempo\tabelle\Associazione;

function elencoAssociazioni()
{
    $dataset = Associazione::elencoAssociazioni();
    AiutoApi::inviaJSON($dataset);
}

function getAssociazione()
{
    $id = AiutoInput::leggiIntero('id', 0, "G");
    $associazione = new Associazione();
    $carica = $associazione->carica($id);
    if ($carica) {
        AiutoApi::inviaJSON($associazione);
    } else {
        http_response_code(404);
    }
}


function putAssociazione()
{
    try {
        $assoc = new Associazione();

        $assoc->id_associazione = AiutoInput::leggiIntero('id_associazione', -1, 'P');
        $assoc->ragsoc = AiutoInput::leggiStringa('ragsoc', '', 'P');
        $assoc->attivo = AiutoInput::leggiBool('attivo', true, 'P');
        $assoc->codfis = AiutoInput::leggiStringa('codfis', '', 'P');
        $assoc->descrizione = AiutoInput::leggiStringa('descrizione', '', 'P');

        $assoc->salva();
        AiutoApi::inviaJSON($assoc);
    } catch (Exception $ex) {
        AiutoApi::inviaJSON(['error' => $ex->getMessage()], AiutoApi::STATO_HTTP_RICHIESTA_ERRATA);
    }
}



function deleteAssociazione()
{
    $id_assoc = AiutoInput::leggiIntero('id', -1, 'P');
    $assoc = new Associazione();
    $assoc->carica($id_assoc);
    $assoc->elimina();
}

function index()
{
    elencoAssociazioni();
}
