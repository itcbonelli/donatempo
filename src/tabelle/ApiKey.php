<?php

namespace itcbonelli\donatempo\tabelle;

use DateTime;
use DateTimeZone;
use itcbonelli\donatempo\AiutoDB;

/**
 * Chiave api per l'accesso al web service
 */
class ApiKey
{

    public string $apikey_old = "";
    public string $apikey;
    public string $descrizione;
    public DateTime $data_creazione;
    public DateTime $data_scadenza;
    public DateTime $data_rinnovo;
    public bool $attivo = true;


    public function __construct()
    {
        $this->apikey = uniqid("", true);
        $this->data_creazione = new DateTime('now', new DateTimeZone('Europe/Rome'));
    }

    /**
     * Salva la chiave API nel database
     */
    public function salva()
    {
        global $dbconn;
        $adb = new AiutoDB($dbconn);
        $record = [
            'apikey' => $this->apikey,
            'descrizione' => $this->descrizione,
            'data_creazione' => $this->data_creazione,
            'data_scadenza' => $this->data_scadenza,
            'data_rinnovo' => $this->data_rinnovo,
            'attivo' => $this->attivo
        ];

        if (empty($this->apikey_old)) {
            $adb->inserisci('apikey', $record);
        } else {
            $adb->aggiorna('apikey', $record, "apikey='{$this->apikey_old}'");
        }
    }

    /**
     * Elimina la chiave api dal DB
     */
    public function elimina(): bool
    {
        global $dbconn;
        $adb = new AiutoDB($dbconn);
        return boolval($adb->eseguiComando("DELETE FROM apikey WHERE id={$this->id}"));
    }

    /**
     * Determina se la chiave API è scaduta
     */
    public function scaduta(): bool
    {
        //la chiave non è scaduta se la data di scadenza è null, 
        //oppure se la data di scadenza è fissata in un timestamp
        //maggiore del timestamp della data e ora corrente
        return !is_null($this->data_scadenza) && ($this->data_scadenza->getTimestamp() > time());
    }

    public function carica()
    {
        global $dbconn;
        $adb = new AiutoDB($dbconn);
    }
}
