<?php

namespace itcbonelli\donatempo\tabelle;

use DateTimeZone;
use itcbonelli\donatempo\AiutoData;
use itcbonelli\donatempo\AiutoDB;
use itcbonelli\donatempo\Notifica;
use \PDO, \DateTime, \Exception;


/**
 * Record richiesta avanzata da bisognoso
 */
class Richiesta
{

    /**
     * Identificativo richiesta
     * @var int
     */
    public int $id_richiesta = -1;

    /**
     * Identificativo utente richiedente
     * @var int
     */
    public int $richiedente = 0;

    /**
     * Identificativo servizio richiesto
     */
    public $id_servizio = -1;

    /**
     * Data di inserimento della richiesta
     * @var DateTime
     */
    public DateTime $data_inserimento;

    /**
     * Descrizione della richiesta da parte del bisognoso
     * @var string
     */
    public string $note = '';

    /**
     * Data di inizio della richiesta
     * @var DateTime
     */
    public ?DateTime $data_inizio;

    /**
     * Data di fine della richiesta
     * @var DateTime
     */
    public ?DateTime $data_fine;


    /**
     * Data/ora effettiva di inizio della prestazione
     * @var DateTime
     */
    public ?DateTime $data_effettiva_inizio;

    /**
     * Data/ora effettiva di fine della prestazione
     * @var DateTime
     */
    public ?DateTime $data_effettiva_fine;

    /**
     * Codice di stato di avanzamento della richiesta
     * @var int
     */
    public $cod_stato;

    /**
     * Identificativo associazione
     * @var int
     */
    public ?int $id_associazione;

    /**
     * Identificativo volontario a cui è assegnata la richiesta
     * @var int
     */
    public ?int $id_volontario;

    /**
     * Identificativo disponibilità
     * @var int
     */
    public ?int $id_disponibilita;


    public function carica($id_richiesta)
    {
        global $dbconn;
        $adb = new AiutoDB($dbconn);
        $record = $adb->eseguiQuery("SELECT * FROM richieste WHERE id_richiesta=:id", ['id' => $id_richiesta]);
        $this->popolaCampi($record[0]);
        return true;
    }

    public function popolaCampi($record)
    {
        $this->id_richiesta = $record['id_richiesta'];
        $this->richiedente = $record['richiedente'];
        $this->id_servizio = $record['id_servizio'];
        $this->data_inserimento = new DateTime($record['id_richiesta'], new DateTimeZone(TIMEZONE));
        $this->note = $record['note'];
        $this->data_inizio = new DateTime(strtotime($record['data_inizio']), new DateTimeZone(TIMEZONE));
        $this->data_fine = new DateTime(strtotime($record['data_fine']), new DateTimeZone(TIMEZONE));
        $this->data_effettiva_fine = new DateTime(strtotime($record['data_effettiva_fine']), new DateTimeZone(TIMEZONE));
        $this->data_effettiva_inizio = new DateTime(strtotime($record['data_effettiva_inizio']), new DateTimeZone(TIMEZONE));
        $this->cod_stato = $record['cod_stato'];
        $this->id_associazione = $record['id_associazione'];
        $this->id_volontario = $record['id_volontario'];
        $this->id_disponibilita = $record['id_disponibilita'];
    }

    public function salva()
    {
        global $dbconn;
        $record = [];
        $adb = new AiutoDB($dbconn);
        if ($this->id_richiesta > 0) {
        } else {
            $adb->aggiorna('richieste', $record, "id_richiesta={$this->id_richiesta}");
        }
    }

    public function elimina()
    {
        global $dbconn;
        $adb = new AiutoDB($dbconn);
        $query = "DELETE FROM richieste WHERE id_richiesta = :id";
        $adb->eseguiComando($query, ['id' => $this->id_richiesta]);
    }

    public function convalida(): bool
    {
        $valido = true;
        return $valido;
    }

    /**
     * @return Richiesta[]
     */
    public static function ElencoRichieste(): array
    {
        global $dbconn;
        $dataset = [];
        $adb = new AiutoDB($dbconn);
        $query = "SELECT * FROM richieste ORDER BY data_inserimento DESC";
        $dataset = $adb->eseguiQuery($query);
        return $dataset;
    }

    /**
     * Ottiene i dati del richiedente
     * @return Utente
     */
    public function getRichiedente(): Utente
    {
        $richiedente = new Utente();
        $richiedente->carica($this->richiedente);
        return $richiedente;
    }

    /**
     * Ottiene i dati sul servizio richiesto
     */
    public function getServizio(): Servizio
    {
        $serv = new Servizio();
        $serv->carica($this->id_servizio);
        return $serv;
    }

    /**
     * Ottiene lo stato di avanzamento della richiesta corrente
     */
    public function getStatoAvanzamento()
    {
        $s = new StatoAvanzamento();
        $s->carica($this->cod_stato);
        return $s;
    }

    /**
     * 
     * @return Messaggio[]
     */
    public function getMessaggi()
    {
        global $dbconn;
        $dataset = [];
        $adb = new AiutoDB($dbconn);
        $query = "SELECT * FROM messaggi WHERE id_richiesta=:id_richiesta";
        $righe = $adb->eseguiQuery($query);

        foreach ($righe as $riga) {
            $messaggio = new Messaggio();
            $messaggio->popolaCampi($riga);
            $dataset[] = $messaggio;
        }

        return $dataset;
    }

    /**
     * Costruttore
     */
    function __construct()
    {
        $this->data_inserimento = AiutoData::adesso();
    }
}
