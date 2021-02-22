<?php

/**
 * Record comune
 */
class Comune
{

    /**
     * Codice identificativo comune
     */
    public $id_comune;

    /**
     * Denominazione comune
     */
    public $denominazione;

    /**
     * Sigla provincia
     */
    public $provincia;

    /**
     * Identificativo area geografica (zona)
     */
    public $id_area;


    /**
     * Salva le modifiche apportate al record
     * @return bool esito dell'operazione
     */
    public function salva()
    {
    }

    /**
     * Convalida i dati per il salvataggio
     * @return string[] array di messaggi di errore della convalida. Se vuoto significa che la convalida è andata a buon fine.
     */
    public function convalida()
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
     * Carica i dati del record dal database
     * @return bool esito dell'operazione
     */
    public function carica($id)
    {
    }

    /**
     * Ottiene l'elenco dei comuni
     * @return Comune[] array di comuni
     */
    public static function getElencoComuni($prov=null) {
        $comuni=[];
        //popolare l'array
        

        return $comuni;
    }
}
