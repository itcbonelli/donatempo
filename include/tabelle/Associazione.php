<?php

/**
 * Record associazione
 */
class Associazione
{
    /**
     * Identificativo associazione
     */
    public $id_associazione;

    /**
     * Ragione sociale
     */
    public $ragsoc;

    /**
     * Codice fiscale
     */
    public $codfis;

    /**
     * URL dell'immagine del logo
     */
    public $url_logo;

    /**
     * Descrizione dell'associazione
     * @var string
     */
    public $descrizione;

    /**
     * Codici dei settori in cui opera l'associazione
     */
    public $settori = [];

    /**
     * Salva le modifiche apportate al record
     * @return bool esito dell'operazione
     */
    public function salva()
    {
    }

    /**
     * Carica i dati del record dal database
     * @return bool esito dell'operazione
     */
    public function carica($id_associazione)
    {
    }

    /**
     * Elimina il record
     * @return bool esito dell'operazione
     */
    public function elimina()
    {
    }

    /**
     * Convalida i dati dell'associazione per il salvataggio
     * @return string[] array di messaggi di errore della convalida. Se vuoto significa che la convalida è andata a buon fine.
     */
    public function convalida()
    {
    }

    /**
     * Associa un settore all'associazione
     * @param int $id_settore identificativo del settore da associare
     * @return bool esito dell'operazione
     */
    public function associaSettore($id_settore) {

    }

    /**
     * Dissocia un settore all'associazione
     * @param int $id_settore identificativo settore
     * @return bool esito dell'operazione
     */
    public function dissociaSettore($id_settore) {
        
    }

    /**
     * Elimina l'associazione tra servizio e associazione
     * @param int $id_servizio codice del servizio da dissociare dall'associazione corrente
     * @return boolean esito dell'operazione
     */
    public function dissociaServizio($id_servizio) {

    }

    /**
     * Crea l'associazione tra servizio e associazione
     * @param int $id_servizio codice del servizio da associare all'associazione corrente
     * @return boolean esito dell'operazione
     */
    public function associaServizio($id_servizio) {

    }

    

    
}
