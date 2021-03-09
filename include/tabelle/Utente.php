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
        global $dbconn;
    }

    /**
     * Carica i dati del record
     * @param int $id_utente identificativo utente
     * @return bool esito operazione
     */
    public function carica($id_utente)
    {
        global $dbconn;
    }

    /**
     * Determina se esistono utente e password ed imposta 
     * le opportune variabili di sessione
     * @param string $username nome utente
     * @param string $password password
     * @return bool esito dell'accesso
     */
    public static function login($username, $password)
    {
        global $dbconn;

        $username = addslashes($username);
        $password = hash('sha256', $password);

        $query = "SELECT * FROM utenti WHERE username='$username' AND password='$password'";
        $comando = $dbconn->prepare($query);
        $esegui = $comando->execute();

        if ($esegui == true && $riga = $comando->fetch(PDO::FETCH_ASSOC)) {
            $_SESSION['id_utente'] = $riga['id_utente'];
            $_SESSION['username'] = $riga['username'];
            return true;
        } else {
            return false;
        }
    }

    /**
     * Controlla se esiste l'ID Utente specificato
     * @param int $id_utente
     * @return bool vero o falso
     */
    public static function esisteId($id_utente)
    {
    }

    /**
     * Controlla se esiste lo username specificato
     * @param int $username
     * @return bool vero o falso
     */
    public static function esisteUsername($username)
    {
    }

    /**
     * Ottiene il record dell'utente attualmente connesso al sito.
     * Se l'utente non ha eseguito l'accesso restituisce null
     * @return Utente dati dell'utente collegato
     */
    public static function getMioUtente()
    {
        global $dbconn;
    }
}
