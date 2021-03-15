<?php

/**
 * Record Messaggio
 */
class Messaggio
{
    /**
     * Identificativo messaggio
     */
    public $id;

    /**
     * Testo del messaggio
     */
    public $contenuto;

    /**
     * ID mittente
     */
    public $id_mittente;

    /**
     * ID destinatario
     */
    public $id_destinatario;

    /**
     * Data di invio del messaggio
     */
    public $data_invio;

    /**
     * Identificativo
     */
    public $id_richiesta;

    /**
     * Salva le modifiche apportate al record
     * @return bool esito dell'operazione
     */
    public function salva()
    {
        global $dbconn;
        throw new Exception("Non ancora implementato");
    }

    /**
     * Convalida i dati per il salvataggio
     * @return string[] array di messaggi di errore della convalida. Se vuoto significa che la convalida è andata a buon fine.
     */
    public function convalida()
    {
        global $dbconn;
        throw new Exception("Non ancora implementato");
    }

    /**
     * Elimina il record
     * @return bool esito dell'operazione
     */
    public function elimina()
    {
        global $dbconn;
        throw new Exception("Non ancora implementato");
    }

    /**
     * Carica i dati del record dal database
     * @return bool esito dell'operazione
     */
    public function carica($id)
    {
        global $dbconn;
        throw new Exception("Non ancora implementato");
    }

    /**
     * Ottiene l'elenco dei messaggi che riguardano una richiesta specifica
     * @return Messaggio[] array dei messaggi
     */
    public static function getConversazionePerRichiesta($id_richiesta)
    {
        global $dbconn;
        throw new Exception("Non ancora implementato");
    }
}
