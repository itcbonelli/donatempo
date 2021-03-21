<?php

namespace itcbonelli\donatempo\tabelle;

use itcbonelli\donatempo\Notifica;
use \PDO, \DateTime;

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
        global $dbconn;



        throw new \Exception("Non ancora implementato");
    }

    /**
     * Salva il record
     * @return bool esito dell'operazione
     */
    public function salva()
    {
        global $dbconn;
        throw new \Exception("Non ancora implementato");
    }

    /**
     * Elimina il record
     * @return bool esito dell'operazione
     */
    public function elimina()
    {
        global $dbconn;
        throw new \Exception("Non ancora implementato");
    }

    /**
     * Convalida i dati del record
     * @author Giorgio Coraglia
     * @return bool esito operazione
     */
    public function convalida()
    {
        $ris = true;

        if (empty($this->id_utente)) {
            Notifica::accoda("Inserire identificativo utente", Notifica::TIPO_ERRORE);
            $ris = false;
        }
        if (empty($this->cognome)) {
            Notifica::accoda("Inserire cognome", Notifica::TIPO_ERRORE);
            $ris = false;
        }
        if (strlen($this->nome)) {
            Notifica::accoda("inserire nome", Notifica::TIPO_ERRORE);
            $ris = false;
        }

        if (empty($this->telefono)) {
            Notifica::accoda("Inserire telefono", Notifica::TIPO_ERRORE);
            $ris = false;
        }
        /*
        if (empty($this->cod_fis)) {
            Notifica::accoda("Inserire codice fiscale", Notifica::TIPO_ERRORE);
        }
        */
        if (strlen($this->indirizzo)) {
            Notifica::accoda("inserire indirizzo", Notifica::TIPO_ERRORE);
            $ris = false;
        }
        if (empty($this->cap)) {
            Notifica::accoda("Inserire il cap", Notifica::TIPO_ERRORE);
            $ris = false;
        }
        if (empty($this->id_comune)) {
            Notifica::accoda("Inserire identificativo comune", Notifica::TIPO_ERRORE);
            $ris = false;
        }
        return $ris;
    }

    /**
     * Carica il profilo utente
     * @author Beatrice Meinero
     * @return bool esito operazione
     */
    public function carica($id_profilo)
    {
        global $dbconn;

        $query = "SELECT * FROM profili WHERE id_utente=$id_profilo";
        $comando = $dbconn->prepare($query);
        $esegui = $comando->execute();

        if ($esegui == true && $riga = $comando->fetch(PDO::FETCH_ASSOC)) {

            $this->id_utente = $riga['id_utente'];
            $this->cognome = $riga['cognome'];
            $this->nome = $riga['nome'];
            $this->telefono1 = $riga['telefono1'];
            $this->telefono2 = $riga['telefono2'];
            $this->cod_fis = $riga['cod_fis'];
            $this->indirizzo = $riga['indirizzo'];
            $this->cap = $riga['cap'];
            $this->id_comune = $riga['id_comune'];
            $this->id_quartiere = $riga['id_quartiere'];
            $this->fotografia = $riga['fotografia'];
            $this->latitudine = $riga['latitudine'];
            $this->longitudine = $riga['longitudine'];

            return true;
        } else {
            return false;
        }
    }

    /**
     * @return Utente oggetto utente associato al profilo
     */
    public function getUtente()
    {
    }
}
