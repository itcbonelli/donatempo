<?php



namespace itcbonelli\donatempo\calendario;

use DateTime;

class Appuntamento
{
    public DateTime $data;
    public DateTime $ora_inizio;
    public DateTime $ora_fine;
    public string $descrizione;
}
