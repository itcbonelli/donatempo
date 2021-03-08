<?php


/**
 * Record richiesta avanzata da bisognoso
 */
class Richiesta
{

    /**
     * Identificativo richiesta
     * @var int
     */
    public $id_richiesta;

    /**
     * Identificativo utente richiedente
     * @var int
     */
    public $richiedente;

    /**
     * Identificativo servizio richiesto
     */
    public $id_servizio;

    /**
     * Data di inserimento della richiesta
     * @var DateTime
     */
    public $data_inserimento;

    /**
     * Descrizione della richiesta da parte del bisognoso
     * @var string
     */
    public $note;

    /**
     * Data di inizio della richiesta
     * @var DateTime
     */
    public $data_inizio;

    /**
     * Data di fine della richiesta
     * @var DateTime
     */
    public $data_fine;


    /**
     * Data/ora effettiva di inizio della prestazione
     * @var DateTime
     */
    public $data_effettiva_inizio;

    /**
     * Data/ora effettiva di fine della prestazione
     * @var DateTime
     */
    public $data_effettiva_fine;

    /**
     * Codice di stato di avanzamento della richiesta
     * @var int
     */
    public $cod_stato;

    /**
     * Costruttore
     */
    function __construct()
    {
        $this->data_inserimento = new DateTime('now');
    }
}
