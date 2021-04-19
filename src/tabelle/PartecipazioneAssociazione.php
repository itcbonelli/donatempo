<?php

namespace itcbonelli\donatempo\tabelle;
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
    public $id_partecipazione;

    /**
     * Identificativo utente partecipante
     * @var int
     */
    public $idUtente;

    /**
     * Identificativo associazione
     * @var int
     */
    public $idAssociazione;

    /**
     * Ruolo ricoperto nell'associazione
     * @var string
     */
    public $ruolo;


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
            $this->idUtente = $riga['idUtente'];
            $this->idAssociazione = $riga['idAssociazione'];
            $this->ruolo = $riga['ruolo'];
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
                $partecipa->idUtente = $riga['utenti_id_utente'];
                $partecipa->idAssociazione = $riga['associazioni_id_associazione'];
                $partecipa->ruolo = $riga['ruolo'];
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

        $query = "SELECT utenti_id_utente FROM utente_partecipa_associazione WHERE associazioni_id_associazione=$id_associazione";
        $comando = $dbconn->prepare($query);
        $esegui = $comando->execute();

        if ($esegui == true) {
            while ($riga = $comando->fetch()) {
                $part = new PartecipazioneAssociazione();
                $part->idAssociazione = $riga['id_associazione'];
                $part->id_partecipazione = $riga['id_utente'];
                $partecipazioneAssociazione[] = $riga;
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
        //N.B: qua non serve fare query
    }

    /**
     * Ottiene l'oggetto utente legato alla partecipazione corrente
     * @author Gaia Barale
     * @return Utente
     */
    public function getUtente()
    {
        if (!isset($_SESSION['id_utente'])) {
            return null;
        }
        $utente = new Utente();
        $utente->carica($_SESSION['id_utente']);
        return $utente;
    }

    /**
     * Salva il record nel database
     * @return bool esito operazione
     */
    public function salva()
    {
        global $dbconn;
        throw new Exception("Non ancora implementato");
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
