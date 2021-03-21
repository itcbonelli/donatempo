<?php

namespace itcbonelli\donatempo\tabelle;
use itcbonelli\donatempo\Notifica;
use \PDO, \DateTime, \Exception;

/**
 * Record Messaggio
 */
class Messaggio
{
    /**
     * Identificativo messaggi
     */
    public $id;

    /**
     * Testo del messaggi
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
     * Data di invio del messaggi
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
     * @author Carola Cometto
     * @param int $id_richiesta identificativo richiesta
     * @return Messaggio[] array dei messaggi
     */
    public static function getConversazionePerRichiesta(int $id_richiesta)
    {
        global $dbconn;

        $messaggi= [];

        //il controllo eseguito non è necessario perché ID richiesta
        //è obbligatorio.

        $query = "SELECT * FROM messaggi WHERE id_richiesta=$id_richiesta";

        
        $comando = $dbconn->prepare($query);
        $esegui = $comando->execute();

        if ($esegui == true) {
            while ($riga = $comando->fetch()) {
                $mess = new Messaggio();
                $mess->id_richiesta = $riga['id_richiesta'];
                $mess->id_destinatario = $riga['id_destinatario'];
                $mess->contenuto = $riga['contenuto'];
                $messaggi[] = $mess;
            }
        }
        return $messaggi;
    }
}
