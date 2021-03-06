<?php

namespace itcbonelli\donatempo\tabelle;

use itcbonelli\donatempo\AiutoDB;
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
    public static function esiste($id_utente)
    {
        global $dbconn;
        $dba = new AiutoDB($dbconn);
        return intval($dba->eseguiScalare("SELECT count(id_utente) FROM profili WHERE id_utente={$id_utente}"));
    }

    /**
     * Salva il record
     * @return bool esito dell'operazione
     */
    public function salva()
    {
        global $dbconn;
        $dba = new AiutoDB($dbconn);
        $record = [
            'id_utente' => intval($this->id_utente),
            'cognome' => $this->cognome,
            'nome' => $this->nome,
            'telefono1' => $this->telefono1,
            'telefono2' => $this->telefono2,
            'cod_fis' => $this->cod_fis,
            'indirizzo' => $this->indirizzo,
            'cap' => $this->cap,
            'id_comune' => $this->id_comune,
            'id_quartiere' => intval($this->id_quartiere),
            'fotografia' => $this->fotografia,
            'longitudine' => floatval($this->longitudine),
            'latitudine' => floatval($this->latitudine)
        ];

        //se non ho il comune rimuovo il campo dal record, altrimenti violo il vincolo di integrità referenziale
        if (empty($record['id_comune'])) {
            unset($record['id_comune']);
        }

        //var_dump($record);
        //exit();

        if (self::esiste($this->id_utente)) {
            return boolval($dba->aggiorna('profili', $record, "id_utente={$this->id_utente}"));
        } else {
            return boolval($dba->inserisci('profili', $record));
        }
    }

    /**
     * Elimina il record
     * @return bool esito dell'operazione
     */
    public function elimina()
    {
        global $dbconn;
        $dba = new AiutoDB($dbconn);
        $esegui = $dba->eseguiQuery("DELETE FROM profili WHERE id_utente={$this->id_utente}");
        return intval($esegui);
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
     * Carica l'elenco dei profili
     * @return Profilo[]
     */
    public static function elencoProfili($cerca = "", $citta = "")
    {
        global $dbconn;
        $adb = new AiutoDB($dbconn);
        $parametri = [];
        $dataset = [];
        $query = "SELECT * FROM profili WHERE 1=1 ";
        if (!empty($cerca)) {
        }
        if (!empty($citta)) {
            $query .= " AND comune=:citta ";
            $parametri['citta'] = $citta;
        }

        $risultato = $adb->eseguiQuery($query, $parametri);
        foreach ($risultato as $record) {
            $pro = new Profilo();
            foreach ($record as $k => $v) {
                $pro->$k = $v;
            }
            $dataset[] = $pro;
        }
        return $dataset;
    }



    /**
     * @return Utente oggetto utente associato al profilo
     */
    public function getUtente()
    {
        $utente = new Utente();
        $utente->carica($this->id_utente);
        return $utente;
    }
}
