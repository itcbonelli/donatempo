<?php

class PartecipazioneAssociazione {
    /**
     * Valore del campo ruolo per il volontario
     */
    const RUOLO_VOLONTARIO = 'volontario';

    /**
     * Valore del campo ruolo per l'amministratore
     */
    const RUOLO_AMMINISTRATORE = 'amministratore';
    
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


    
    public function salva() {

    }

    public function elimina() {

    }

    
}