<?php

namespace itcbonelli\donatempo\tabelle;

use itcbonelli\donatempo\AiutoData;
use itcbonelli\donatempo\AiutoDB;
use itcbonelli\donatempo\filtri\FiltroDisponibilita;
use itcbonelli\donatempo\Notifica;
use \PDO, \DateTime, \Exception;

/**
 * Record disponibilità volontario
 */
class Disponibilita
{
    /**
     * Identificativo disponibilità
     */
    public int $id_disponibilita = -1;

    /**
     * Identificativo partecipazione tra volontario e associazione
     */
    public int $id_partecipazione;

    /**
     * Data di disponibilità (giorno)
     * @var DateTime
     */
    public DateTime $data_disp;

    /**
     * Ora inizio disponibilità
     * @var DateTime
     */
    public DateTime $ora_inizio;

    /**
     * Ora fine disponibilità
     * @var DateTime
     */
    public DateTime $ora_fine;

    public function __construct()
    {
        $this->data_disp = new DateTime();
        $this->ora_inizio = new DateTime();
        $this->ora_fine = new DateTime();
    }

    /**
     * Convalida i dati inseriti
     * @author Giorgio Coraglia
     * @return bool esito convalida
     */
    public function convalida()
    {
        $errori = [];

        if (empty($this->id_disponibilita)) {
            $errori[] = "Inserire identificativo disponibilita";
        }
        if (empty($this->id_partecipazione)) {
            $errori[] = "Inserire identificativo partecipazione";
        }

        $errori = [];

        if (empty($this->ora_inizio)) {
            $errori[] = "inserire l'ora di inizio";
        }
        if (empty($this->ora_fine)) {
            $errori[] = "Inserire ora fine";
        }

        return $errori;
    }

    /**
     * Salva il record della disponibilità
     * @return bool esito salvataggio
     */
    public function salva()
    {
        global $dbconn;
        $adb = new AiutoDB($dbconn);
        $record = [
            'id_partecipazione' => $this->id_partecipazione,
            'data_disp' => $this->data_disp->format('Y-m-d'),
            'ora_inizio' => $this->ora_inizio->format('H:i:s'),
            'ora_fine' => $this->ora_fine->format('H:i:s'),
        ];



        if ($this->id_disponibilita == -1) {
            $ins = $adb->inserisci('disponibilita', $record, 'id_disponibilita');
            
            if ($ins==1) {
                
                $this->id_disponibilita = $record['id_disponibilita'];
                return true;
            } else {
                Notifica::accoda('Errore salvataggio disponibilità', Notifica::TIPO_ERRORE);
                return false;
            }
        } else {
            $adb->aggiorna('disponibilita', $record, 'id_disponibilita=' . $record['id_disponibilita']);
            return true;
        }
    }

    /**
     * @author Gaia Barale
     * @return bool esito eliminazione
     */
    public function elimina()
    {
        global $dbconn;
        $query = "DELETE FROM disponibilita WHERE id_disponibilita='{$this->id_disponibilita}'";
        $comando = $dbconn->prepare($query);
        $esegui = $comando->execute();
        return $esegui == true && $comando->rowCount() == 1;
    }

    /**
     * @author Carola Nerattini
     */
    public function carica($id_disponibilita)
    {
        global $dbconn;

        $query = "SELECT * FROM disponibilita WHERE id_disponibilita=$id_disponibilita";
        $comando = $dbconn->prepare($query);
        $esegui = $comando->execute();

        if ($esegui == true && $riga = $comando->fetch(PDO::FETCH_ASSOC)) {
            $this->id_disponibilita = $riga['id_disponibilita'];
            $this->id_partecipazione = $riga['id_partecipazione'];
            $this->data_disp = AiutoData::daStringaDB($riga['data_disp'], 'Y-m-d');
            $this->ora_inizio = AiutoData::daStringaDB($riga['ora_inizio'], 'H:i:s');
            $this->ora_fine = AiutoData::daStringaDB($riga['ora_fine'], 'H:i:s');

            return true;
        } else {
            return false;
        }
    }

    /**
     * Ottiene le disponibilità di tempo un determinato utente
     * @param int $id_utente identificativo utente
     * @param int $anno anno in cui ricercare
     * @param int $mese mese in cui ricercare
     * @return array Oggetti di tipo disponibilità
     */
    public static function getDisponibilitaUtente(int $id_utente, int $anno, int $mese)
    {
        global $dbconn;
        $adb = new AiutoDB($dbconn);
        $dati = $adb->eseguiQuery("SELECT disponibilita.*, ass.ragsoc AS associazione
        FROM disponibilita 
        JOIN utente_partecipa_associazione part ON part.id_partecipazione = disponibilita.id_partecipazione
        JOIN associazioni ass ON ass.id_associazione = part.associazioni_id_associazione
        WHERE year(data_disp)=$anno AND month(data_disp)=$mese
        AND part.utenti_id_utente=$id_utente");
        return $dati;
    }


    /**
     * Ottiene la partecipazione ad associazione collegata alla disponibilità di tempo corrente.
     * @return PartecipazioneAssociazione
     */
    public function getPartecipazione()
    {
        $part = new PartecipazioneAssociazione();
        $part->carica($this->id_partecipazione);
        return $part;
    }

    /**
     * Ottiene i dati del volontario
     * @return Utente
     * @deprecated richiamare invece getUtente
     */
    public function getVolontario()
    {
        $part = $this->getPartecipazione();
        $profilo = new Utente();
        $profilo->carica($part->idUtente);
    }

    /**
     * Ottiene il record utente del volontario
     * @return Utente
     */
    public function getUtente()
    {
        $part = $this->getPartecipazione();
        $ut = new Utente();
        $ut->carica($part->id_utente);
        return $ut;
    }

    /**
     * Associa un servizio alla disponibilità data
     * @author Llozhi Matteo
     * @return bool esito operazione
     */
    public function associaServizio($id_servizio)
    {
        global $dbconn;
        $dba = new AiutoDB($dbconn);
        $rec = [
            'id_disponibilita' => $this->id_disponibilita,
            'id_servizio' => intval($id_servizio)
        ];
        return boolval($dba->inserisci('disponibilita_include_servizi', $rec));
    }

    /**
     * dissocia un servizio alla disponibilità data
     * @author Llozhi Matteo
     * @return bool esito operazione
     */
    public function dissociaServizio($id_servizio)
    {
        global $dbconn;
        $dba = new AiutoDB($dbconn);
        $esegui = $dba->eseguiComando("DELETE FROM disponibilita_include_servizi WHERE id_disponibilita=:idd AND id_servizio=:ids", [
            'idd' => $this->id_disponibilita,
            'ids' => intval($id_servizio)
        ]);
        return boolval($esegui);
    }

    /**
     * Ricerca le disponibilità di tempo in base ai filtri impostati
     * @param FiltroDisponibilita $filtri filtri per la ricerca
     * @return array record disponibilita che soddisfano la richiesta
     */
    public static function ricercaDisponibilita(FiltroDisponibilita $filtri)
    {
        global $dbconn;
        $dba = new AiutoDB($dbconn);

        $query = "SELECT disponibilita.*
        FROM disponibilita
        JOIN utente_partecipa_associazione as partecipa on partecipa.id_partecipazione = disponibilita.id_partecipazione
        JOIN profili ON profili.id_utente = partecipa.utenti_id_utente
        WHERE 1=1
        
        AND disponibilita.ora_inizio = '17:00'
        AND disponibilita.ora_fine = '18:00' ";
        if (!empty($filtri->data_inizio)) {
            $query .= " AND disponibilita.data_disp >= '" . $filtri->data_inizio->format('Y-m-d') . "'";
        }
        if (!empty($filtri->data_fine)) {
            $query .= " AND disponibilita.data_disp <= '" . $filtri->data_fine->format('Y-m-d') . "'";
        }
        if (!empty($filtri->cod_comune)) {
            $query .= " AND profili.id_comune = 'D205' ";
        }

        $dataset = $dba->eseguiQuery($query);
        return $dataset;
    }
}
