<?php

namespace itcbonelli\donatempo\tabelle;

use DateTime;
use DateTimeZone;
use itcbonelli\donatempo\AiutoDB;
use itcbonelli\donatempo\Notifica;

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

    /**
     * Crea una nuova istanza di ApiKey
     * @param $ak eventuale chiave API da caricare
     */
    public function __construct($ak = "")
    {
        if (empty($ak)) {
            $this->apikey = uniqid("", true);
            $this->data_creazione = new DateTime('now', new DateTimeZone('Europe/Rome'));
        } else {
            $this->carica($ak);
        }
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

    /**
     * Carica un record dal database
     * @param string $apikey chiave api da caricare
     */
    public function carica(string $apikey)
    {
        global $dbconn;
        $adb = new AiutoDB($dbconn);
        $record = $adb->eseguiQuery("SELECT * FROM apikey WHERE apikey=:ak", ['ak' => $apikey]);
        if ($record) {
            $this->apikey_old = $record['apikey'];
            $this->apikey = $record['apikey'];
            $this->descrizione = $record['descrizione'];
            $this->data_creazione = DateTime::createFromFormat('Y-m-d h:i:s', $record['data_creazione'], new DateTimeZone(TIMEZONE));
            $this->data_rinnovo = DateTime::createFromFormat('Y-m-d h:i:s', $record['data_rinnovo'], new DateTimeZone(TIMEZONE));
            $this->data_scadenza = DateTime::createFromFormat('Y-m-d h:i:s', $record['data_scadenza'], new DateTimeZone(TIMEZONE));
            $this->attivo = boolval($record['attivo']);
            return true;
        }

        return false;
    }

    /**
     * Determina se una chiave API esiste, è attiva e non è scaduta
     * @param $apikey chiave api da controllare
     */
    public static function controlla(string $apikey)
    {
        $ak = new ApiKey();
        $carica = $ak->carica($apikey);
        if (!$carica) {
            Notifica::accoda("Chiave API $apikey inesistente", Notifica::TIPO_ERRORE);
            return false;
        }

        if ($ak->attivo == false) {
            Notifica::accoda("Chiave API $apikey non attiva", Notifica::TIPO_ERRORE);
            return false;
        }

        if ($ak->scaduta()) {
            Notifica::accoda("Chiave API $apikey scaduta", Notifica::TIPO_ERRORE);
            return false;
        }

        return true;
    }
}
