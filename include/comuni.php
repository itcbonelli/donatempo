<?php

/**
 * Ottiene l'elenco dei comuni italiani, eventualmente filtrati per provincia
 * @deprecated
 */
function getElencoComuni($prov=null) {
    throw new Exception("Caratteristica da implementare");
}

/**
 * Ottiene l'elenco delle province italiane
 * @deprecated
 */
function getElencoProvince() {
    throw new Exception("Caratteristica da implementare");
}

/**
 * Crea un comune
 * @deprecated usare Comuni::getElencoComuni()
 */
function creaComune($denominazione, $prov) {
    throw new Exception("Caratteristica da implementare");
}