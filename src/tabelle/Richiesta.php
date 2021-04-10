<?php

namespace itcbonelli\donatempo\tabelle;

use itcbonelli\donatempo\Notifica;
use \PDO, \DateTime, \Exception;


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

    public function carica($id_richiesta)
    {
    }

    public function salva()
    {
    }

    public function elimina()
    {
    }

    public function convalida(): bool
    {
        $valido = true;

        return $valido;
    }

    /**
     * @return Richiesta[]
     */
    public static function ElencoRichieste(): array
    {
        $dataset = [];

        return $dataset;
    }

    /**
     * Ottiene i dati del richiedente
     * @return Utente
     */
    public function getRichiedente(): Utente
    {
        $richiedente = new Utente();
        $richiedente->carica($this->richiedente);
        return $richiedente;
    }

    /**
     * Ottiene i dati sul servizio richiesto
     */
    public function getServizio(): Servizio
    {
        $serv = new Servizio();
        $serv->carica($this->id_servizio);
        return $serv;
    }

    /**
     * 
     */
    public function getStatoAvanzamento()
    {
        $s = new StatoAvanzamento();
        $s->carica($this->cod_stato);
        return $s;
    }

    /**
     * Costruttore
     */
    function __construct()
    {
        $this->data_inserimento = new DateTime('now');
    }
}
