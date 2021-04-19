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
    public DateTime $ora_inizio;

    /**
     * Ora di fine
     */
    public DateTime $ora_fine;

    /**
     * Descrizione dell'appuntamento
     */
    public string $descrizione;
}
