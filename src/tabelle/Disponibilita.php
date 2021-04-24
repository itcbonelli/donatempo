<?php

namespace itcbonelli\donatempo\tabelle;

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
    public $id_disponibilita = -1;

    /**
     * Identificativo partecipazione tra volontario e associazione
     */
    public $id_partecipazione;

    /**
     * Data di disponibilità (giorno)
     * @var DateTime
     */
    public $data_disp;

    /**
     * Ora inizio disponibilità
     * @var DateTime
     */
    public $ora_inizio;

    /**
     * Ora fine disponibilità
     * @var DateTime
     */
    public $ora_fine;

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
        if (strlen($this->data_disp)) {
            $errori[] = "inserire la data di disponibilita";
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
            'id_partecipazione' => $this->partecipazione,
            'data_disp' => $this->data_disp->format('Y-m-d'),
            'ora_inizio' => $this->ora_inizio->format('h:i:s'),
            'ora_fine' => $this->ora_fine->format('h:i:s'),
        ];

        if ($this->id_disponibilita = -1) {
            if ($adb->inserisci('disponibilita', $record, 'id_disponibilita')) {
                $this->id_disponibilita = $record['id_disponibilita'];
                return true;
            } else {
            }
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
            $this->data_disp = $riga['data_disp'];
            $this->ora_inizio = $riga['ora_inizio'];
            $this->ora_fine = $riga['ora_fine'];

            return true;
        } else {
            return false;
        }
    }

    /**
     * 
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
     * @return Profilo
     */
    public function getVolontario()
    {
        $part = $this->getPartecipazione();
        $profilo = new Profilo();
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
     * 
     */
    public static function ricercaDisponibilita(FiltroDisponibilita $filtri)
    {
        global $dbconn;
        $dba = new AiutoDB($dbconn);

        $query = "SELECT * FROM disponibilita WHERE 1=1 ";
        if (!empty($filtri->data_inizio)) {
            $query .= " AND data_disp >= '" . $filtri->data_inizio->format('Y-m-d') . "'";
        }
        if (!empty($filtri->data_inizio)) {
            $query .= " AND data_disp <= '" . $filtri->data_fine->format('Y-m-d') . "'";
        }
        if (!empty($filtri->cod_comune)) {
        }

        $dataset = $dba->eseguiQuery($query);
    }
}
