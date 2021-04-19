<?php

namespace itcbonelli\donatempo\tabelle;

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
    public $id_disponibilita;

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
        $part=$this->getPartecipazione();
        $profilo=new Profilo();
        $profilo->carica($part->idUtente);
    }

    /**
     * Ottiene il record utente del volontario
     * @return Utente
     */
    public function getUtente()
    {
    }

    /**
     * Associa un servizio alla disponibilità data
     * @author Llozhi Matteo
     * @return bool esito operazione
     */
    public function associaServizio($id_servizio)
    {
        //tabella disponibilita_include_servizi
    }

    /**
     * dissocia un servizio alla disponibilità data
     * @author Llozhi Matteo
     * @return bool esito operazione
     */
    public function dissociaServizio($id_servizio)
    {
        //tabella disponibilita_include_servizi
    }
}
