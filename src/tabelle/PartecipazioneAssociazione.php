<?php

namespace itcbonelli\donatempo\tabelle;

use itcbonelli\donatempo\AiutoDB;
use itcbonelli\donatempo\Notifica;
use \PDO, \DateTime, \Exception;

/**
 * Record di associazione tra utente e associazione di volontariato
 */
class PartecipazioneAssociazione
{
    /**
     * Valore del campo ruolo per il volontario
     */
    const RUOLO_VOLONTARIO = 'volontario';

    /**
     * Valore del campo ruolo per l'amministratore
     */
    const RUOLO_AMMINISTRATORE = 'amministratore';

    /**
     * Identificativo record partecipazione
     * @var int
     */
    public $id_partecipazione = -1;

    /**
     * Identificativo utente partecipante
     * @var int
     */
    public $id_utente;

    /**
     * Identificativo associazione
     * @var int
     */
    public $id_associazione;

    /**
     * Ruolo ricoperto nell'associazione
     * @var string
     */
    public $ruolo;

    /**
     * Indica che la partecipazione all'associazione è stata verificata dall'associazione stessa.
     * @var boolean
     */
    public bool $confermato = false;


    /**
     * Carica il record della partecipazione
     * @author Beatrice Meinero
     * @param int $id identificativo partecipazione
     * @return bool esito del caricamento
     */
    public function carica($id)
    {
        global $dbconn;
        $query = "SELECT * FROM utente_partecipa_associazione WHERE id_partecipazione=$id";
        $comando = $dbconn->prepare($query);
        $esegui = $comando->execute();

        if ($esegui == true && $riga = $comando->fetch(PDO::FETCH_ASSOC)) {
            $this->id_partecipazione = $riga['id_partecipazione'];
            $this->id_utente = $riga['id_utente'];
            $this->id_associazione = $riga['id_associazione'];
            $this->ruolo = $riga['ruolo'];
            $this->confermato = boolval($riga['confermato']);
            return true;
        } else {
            return false;
        }
    }




    /**
     * Ottiene le partecipazioni ad associazioni di un dato utente
     * @author Ramonda Samuele
     * @param int $id_utente identificativo utente
     * @return PartecipazioneAssociazione[] array di record Partecipazione
     */
    public static function getPartecipazioniUtente($id_utente)
    {
        global $dbconn;

        $partecipazioneAssociazione = [];

        $query = "SELECT * FROM utente_partecipa_associazione";
        if ($id_utente != null) {
            $query .= " WHERE utenti_id_utente= $id_utente";
        }
        $query .= " ORDER BY associazioni_id_associazione";

        $comando = $dbconn->prepare($query);
        $esegui = $comando->execute();

        if ($esegui == true) {
            while ($riga = $comando->fetch()) {
                $partecipa = new PartecipazioneAssociazione();
                $partecipa->id_partecipazione = $riga['id_partecipazione'];
                $partecipa->id_utente = $riga['utenti_id_utente'];
                $partecipa->id_associazione = $riga['associazioni_id_associazione'];
                $partecipa->ruolo = $riga['ruolo'];
                $partecipa->confermato = $riga['confermato'];
                $partecipazioneAssociazione[] = $partecipa;
            }
        }
        return $partecipazioneAssociazione;
    }



    /**
     * Ottiene le partecipazioni ad associazioni degli utenti assegnati ad una data associazione
     * @author Pagliasso Alessia
     * @param int $id_utente identificativo utente
     * @return PartecipazioneAssociazione[] array di record partecipazione
     */
    public static function getPartecipantiAssociazione($id_associazione)
    {
        global $dbconn;

        $partecipazioneAssociazione = [];

        $query = "SELECT * FROM utente_partecipa_associazione WHERE associazioni_id_associazione=$id_associazione";
        $comando = $dbconn->prepare($query);
        $esegui = $comando->execute();

        if ($esegui == true) {
            while ($riga = $comando->fetch()) {
                $part = new PartecipazioneAssociazione();
                $part->id_partecipazione = $riga['id_partecipazione'];
                $part->id_associazione = $riga['associazioni_id_associazione'];
                $part->id_utente = $riga['utenti_id_utente'];
                $part->ruolo = $riga['ruolo'];
                $partecipazioneAssociazione[] = $part;
            }
            return $partecipazioneAssociazione;
        } else {
            return [];
        }
    }

    /**
     * Ottiene l'oggetto associazione legato all'ID associazione di questa partecipazione
     * @return Associazione oggetto associazione
     */
    public function getAssociazione()
    {
        $assoc = new Associazione();
        $assoc->carica($this->id_associazione);
        return $assoc;
    }

    /**
     * Ottiene l'oggetto utente legato alla partecipazione corrente
     * @author Gaia Barale
     * @return Utente
     */
    public function getUtente()
    {
        /*
        NO!
        if (!isset($_SESSION['id_utente'])) {
            return null;
        }
        $utente = new Utente();
        $utente->carica($_SESSION['id_utente']);
        return $utente; 
        */
        $utente = new Utente();
        $utente->carica($this->id_utente);
        return $utente;
    }

    /**
     * Salva il record nel database
     * @return bool esito operazione
     */
    public function salva()
    {
        global $dbconn;
        $adb = new AiutoDB($dbconn);
        $record = [
            'utenti_id_utente' => $this->id_utente,
            'associazioni_id_associazione' => $this->id_associazione,
            'ruolo' => $this->ruolo
        ];

        if ($this->id_partecipazione == -1) {
            if ($adb->inserisci('utente_partecipa_associazione', $record, 'id_partecipazione')) {
                $this->id_partecipazione = $record['id_partecipazione'];
                return true;
            }
        } else {
            if ($adb->aggiorna('utente_partecipa_associazione', $record, "id_partecipazione={$this->id_partecipazione}")) {
                return true;
            }
        }

        return false;
    }


    /**
     * Controlla se esiste una partecipazione per l'utente
     * @return bool
     */
    public static function controlla($id_utente, $id_associazione)
    {
        global $dbconn;
        $adb = new AiutoDB($dbconn);
        $query = "SELECT count(*) FROM utente_partecipa_associazione WHERE utenti_id_utente=:u AND associazioni_id_associazione=:a";
        $risultato = $adb->eseguiScalare($query, ['u' => $id_utente, 'a' => $id_associazione]);
        return boolval($risultato);
    }

    /**
     * Elimina il record nel database
     * @author Coraglia Giorgio
     * @return bool esito operazione
     */
    public function elimina()
    {
        global $dbconn;
        throw new Exception("Non ancora implementato");

        $query = "DELETE FROM utente_partecipa_associazione WHERE id_partecipazione='{$this->id_partecipazione}'";
        $comando = $dbconn->prepare($query);
        $esegui = $comando->execute();
        return $esegui == true && $comando->rowCount() == 1;
    }
}
