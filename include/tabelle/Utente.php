<?php

/**
 * Record utente
 */
class Utente
{
    /**
     * Identificativo
     */
    public int $id_utente;

    /**
     * Nome utente
     */
    public $username;

    /**
     * Password
     */
    public string $password;

    /**
     * Data e ora di creazione dell'utente
     */
    public DateTime $data_creazione;

    /**
     * Data e ora dell'ultimo accesso
     */
    public DateTime $ultimo_accesso;

    /**
     * Indirizzo e-mail
     */
    public string $email;

    /**
     * Attivo sì/no
     */
    public bool $attivo = true;

    /**
     * Eliminato sì/no
     */
    public bool $eliminato = false;

    /**
     * Data di eliminazione del profilo
     */
    public int $data_eliminazione;

    /**
     * Numero di telefono
     */
    public string $telefono;

    /**
     * Volontario sì/no
     */
    public bool $volontario;

    /**
     * Salva il record nel database
     * @return bool esito dell'operazione
     */
    public function salva()
    {
    }

    /**
     * Carica i dati del record
     * @param int $id_utente identificativo utente
     * @return bool esito operazione
     */
    public function carica($id_utente)
    {
    }

    /**
     * Determina se esistono utente e password ed imposta le opportune variabili di sessione
     * @param string $username nome utente
     * @param string $password password
     * @return bool esito dell'accesso
     */
    public static function login($username, $password) {

    }

    /**
     * Ottiene il record dell'utente attualmente connesso al sito.
     * Se l'utente non ha eseguito l'accesso restituisce null
     * @return Utente
     */
    public static function getMioUtente() {

    }

}
