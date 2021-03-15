<?php

/**
 * Record disponibilità volontario
 */
class Disponibilita {
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
     * @return bool esito convalida
     */
    public function convalida() {

    }

    /**
     * @return bool esito salvataggio
     */
    public function salva() {

    }

    /**
     * @return bool esito eliminazione
     */
    public function elimina() {

    }

    /**
     * 
     */
    public function carica($id_disponibilita) {

    }

    /**
     * 
     * @return PartecipazioneAssociazione
     */
    public function getPartecipazione() {

    }

    /**
     * Ottiene i dati del volontario
     * @return Profilo
     */
    public function getVolontario() {

    }

    /**
     * Ottiene il record utente del volontario
     * @return Utente
     */
    public function getUtente() {

    }

    /**
     * Associa un servizio alla disponibilità data
     * @author Llozhi Matteo
     * @return bool esito operazione
     */
    public function associaServizio($id_servizio) {
        //tabella disponibilita_include_servizi
    }

    /**
     * dissocia un servizio alla disponibilità data
     * @author Llozhi Matteo
     * @return bool esito operazione
     */
    public function dissociaServizio($id_servizio) {
        //tabella disponibilita_include_servizi
    }



}