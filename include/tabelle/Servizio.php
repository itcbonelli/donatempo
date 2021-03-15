<?php

/**
 * Record servizio
 */
class Servizio {
    
    /**
     * Identificativo servizio
     * @var int
     */
    public $id_servizio;
    
    /**
     * Nome servizio
     * @var string
     */
    public $nome;
    
    /**
     * Descrizione servizio
     * @var string
     */
    public $descrizione;
    
    /**
     * Codice tipologia servizio
     * @var int
     */
    public $tipo;

    /**
     * Durata della prestazione
     * @var int
     */
    public $durata;

    /**
     * Servizio attivo (sì/no)
     * @var int
     */
    public $attivo=1;

    /**
     * Salva il servizio
     * @return bool esito operazione
     */
    public function salva() {
        
    }

    /**
     * @param int $id_servizio id servizio da caricare
     * @return bool esito operazione
     */
    public function carica($id_servizio) {

    }

    /**
     * Esegue la convalida dei dati
     * @return bool esito operazione
     */
    public function convalida() {

    }

    /**
     * Elimina il servizio corrente
     * @return bool esito operazione
     */
    public function elimina() {

    }

    /**
     * Ottiene l'elenco dei servizi disponibili
     * @param bool $solo_attivi se vale true vengono mostrati solo i servizi attivi
     * @return Servizio[]
     */
    public static function elencoServizi($solo_attivi=true) {
        $dataset=[];

        return $dataset;
    }

}