<?php

/**
 * Record Messaggio
 */
class Messaggio {
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
     * Ottiene l'elenco dei messaggi che riguardano una richiesta specifica
     * @return Messaggio[] array dei messaggi
     */
    public static function getConversazionePerRichiesta($id_richiesta) {

    }
}