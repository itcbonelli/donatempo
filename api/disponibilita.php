<?php

use itcbonelli\donatempo\AiutoApi;
use itcbonelli\donatempo\AiutoInput;
use itcbonelli\donatempo\filtri\FiltroDisponibilita;
use itcbonelli\donatempo\tabelle\Disponibilita;
use itcbonelli\donatempo\tabelle\PartecipazioneAssociazione;

function elencoDisponibilita()
{
    $data_inizio = AiutoInput::leggiData('data_inizio', null, 'P');
    $data_fine = AiutoInput::leggiData('data_fine', null, 'P');
    $id_servizio = AiutoInput::leggiIntero('id_servizio', -1, 'P');
    $id_associazione = AiutoInput::leggiIntero('id_servizio', -1, 'P');

    $filtro = new FiltroDisponibilita();
    $filtro->data_inizio = $data_inizio;
    $filtro->data_fine = $data_fine;
    $filtro->id_servizio = $id_servizio;
    $filtro->id_associazione = $id_associazione;
    

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
    $io = AiutoApi::autentica();
    $id_associazione = AiutoInput::leggiIntero('id_associazione', -1, 'P');
    $id_disponibilita = PartecipazioneAssociazione::controlla($io->id_utente, $id_associazione);
    $data_disp = AiutoInput::leggiData('data_disp', null, 'P');

    
}

function deleteDisponibilita()
{
    $io = AiutoApi::autentica();
    $id_disponibilita = AiutoInput::leggiIntero('id_disponibilita', -1, 'P');
}
