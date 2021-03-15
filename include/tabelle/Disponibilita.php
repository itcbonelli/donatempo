<?php

class Disponibilita {
    public $id_disponibilita;
    public $id_partecipazione;
    public $data_disp;
    public $ora_inizio;
    public $ora_fine;

    /**
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
}