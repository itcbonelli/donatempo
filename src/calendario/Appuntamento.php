<?php



namespace itcbonelli\donatempo\calendario;

use DateTime;

/**
 * Codifica un appuntamento del calendario
 */
class Appuntamento
{
    /**
     * Data appuntamento
     */
    public DateTime $data;

    /**
     * Ora di inizio
     */
    public ?DateTime $ora_inizio = null;

    /**
     * Ora di fine
     */
    public ?DateTime $ora_fine = null;

    /**
     * Descrizione dell'appuntamento
     */
    public string $descrizione = "";

    /**
     * Link alla pagina di dettaglio dell'appuntamento
     */
    public string $link = "";

    public function __construct() {
        $this->data = new DateTime();
    }
}
