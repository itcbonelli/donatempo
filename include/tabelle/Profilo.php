<?php

/**
 * Rappresenta il profilo associato ad un utente
 */
class Profilo
{

    /**
     * Identificativo utente
     */
    public $id_utente;

    /**
     * Cognome
     */
    public $cognome;

    /**
     * Nome
     */
    public $nome;

    /**
     * Numero di telefono principale
     */
    public $telefono1;

    /**
     * Numero di telefono secondario
     */
    public $telefono2;

    /**
     * Codice fiscale
     */
    public $cod_fis;

    /**
     * Indirizzo
     */
    public $indirizzo;

    /**
     * Cap
     */
    public $cap;

    /**
     * identificativo comune di residenza
     */
    public $id_comune;

    /**
     * Identificativo del quartiere
     * @deprecated
     */
    public $id_quartiere;

    /**
     * URL della fotografia dell'utente
     */
    public $fotografia;

    /**
     * Latitudine dell'utente
     */
    public $latitudine;

    /**
     * Longitudine dell'utente
     */
    public $longitudine;

    /**
     * Determina se esiste un record per l'ID specificato
     * @return bool esiste sì/no
     */
    public function esiste($id_utente)
    {
    }

    /**
     * Salva il record
     * @return bool esito dell'operazione
     */
    public function salva()
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
     * Convalida i dati del record
     */
    public function convalida()
    {
        $errori=[];

        return $errori;
    }
}
