<?php

namespace itcbonelli\donatempo\tabelle;

use DateTimeZone;
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
    public int $id = -1;

    /**
     * Testo del messaggi
     */
    public string $contenuto;

    /**
     * ID mittente
     */
    public int $id_mittente;

    /**
     * ID destinatario
     */
    public int $id_destinatario;

    /**
     * Data di invio del messaggi
     */
    public DateTime $data_invio;

    /**
     * Identificativo
     */
    public int $id_richiesta;

    /**
     * Salva le modifiche apportate al record
     * @author Andrea Lops
     * @return bool esito dell'operazione
     */
    public function salva()
    {
        global $dbconn;

        //se sono presenti errori di convalida
        if ($this->convalida() == false) {
            //esco dalla funzione
            return false;
        }

        $id = $this->id;
        $contenuto = addslashes($this->contenuto);
        $id_mittente = $this->id_mittente;
        $id_destinatario = $this->id_destinatario;
        $data_invio = $this->data_invio->format('Y-m-d H:i:s');
        $id_richiesta = $this->id_richiesta;

        if ($this->id==-1) {
            $query = "INSERT INTO messaggi(id, contenuto, id_mittente, id_destinatario, data_invio, id_richiesta)
            VALUES ('$id', '$contenuto', $id_mittente, $id_destinatario, '$data_invio', $id_richiesta)";
            die($query);
            $comando = $dbconn->prepare($query);
            $esegui = $comando->execute();

            if ($esegui == true && $comando->rowCount() == 1) {
                $this->id = $dbconn->lastInsertId();
                return true;
            } else {
                return false;
            }
        } else {
            $query = "UPDATE messaggi SET
                contenuto='$contenuto',
                id_mittente=$id_mittente,
                id_destinatario=$id_destinatario,
                data_invio='$data_invio',
                id_richiesta = $id_richiesta
            WHERE id = $id";
            $comando = $dbconn->prepare($query);
            $esegui = $comando->execute();

            if ($esegui == true && $comando->rowCount() == 1) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * Convalida i dati per il salvataggio
     * @return bool esito convalida
     */
    public function convalida()
    {
        $esito=true;
        if(empty($contenuto)) {
            Notifica::accoda('Impostare il contenuto del messaggio', Notifica::TIPO_ERRORE);
        }
        return $esito;
    }

    /**
     * Elimina il record
     * @author Giulia Chesta
     * @return bool esito dell'operazione
     */
    public function elimina()
    {
        global $dbconn;
        $query = "DELETE FROM messaggio WHERE id_messaggio='{$this->id_messaggio}'";
        $comando = $dbconn->prepare($query);
        $esegui = $comando->execute();
        return $esegui == true && $comando->rowCount() == 1;
    }

    /**
     * Carica i dati del record dal database
     * @author Francesco Miglietti
     * @return bool esito dell'operazione
     */
    public function carica($id)
    {
        global $dbconn;

        $query = "SELECT * FROM messaggi WHERE id='$id";
        $comando = $dbconn->prepare($query);
        $esegui = $comando->execute();
        if ($esegui == true && $riga = $comando->fetch(PDO::FETCH_ASSOC)) {
            $this->id = $riga['id'];
            $this->contenuto = $riga['contenuto'];
            $this->id_mittente = $riga['id_mittente'];
            $this->id_destinatario = $riga['id_destinatario'];
            $this->data_invio = $riga['data_invio'];
            $this->id_richiesta = $riga['id_richiesta'];

            return true;
        } else {
            return false;
        }
    }

    /**
     * Ottiene l'utente associato al mittente
     * @return Utente
     */
    public function getMittente(): Utente
    {
        $ut = new Utente();
        $ut->carica($this->id_mittente);
        return $ut;
    }

    /**
     * Ottiene l'utente associato al destinatario
     * @return Utente
     */
    public function getDestinatario(): Utente
    {
        $ut = new Utente();
        $ut->carica($this->id_destinatario);
        return $ut;
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

        $messaggi = [];

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

    /**
     * Popola i campi dell'oggetto con i dati presenti in un vettore
     */
    public function popolaCampi(array $dati) {
        $this->id = $dati['id'];
        $this->data_invio = new DateTime(strtotime($dati['data_invio']), new DateTimeZone(TIMEZONE));
        $this->id_richiesta = $dati['id_richiesta'];
        $this->id_destinatario = $dati['id_destinatario'];
        $this->id_mittente = $dati['id_mittente'];
        $this->contenuto = $dati['contenuto'];
        
    }
}
