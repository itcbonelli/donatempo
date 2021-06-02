<?php

use itcbonelli\donatempo\AiutoApi;
use itcbonelli\donatempo\tabelle\Servizio;

function elencoServizi() {
    $dataset=Servizio::elencoServizi();
    AiutoApi::inviaJSON($dataset);
}

function index() {
    elencoServizi();
}