<?php

namespace itcbonelli\donatempo\filtri;

use DateTime;

class FiltroDisponibilita extends FiltroBase
{

    public string $cod_comune = '';
    public ?DateTime $data_inizio = null;
    public ?DateTime $data_fine = null;
    public ?DateTime $ora_inizio = null;
    public ?DateTime $ora_fine = null;
    public int $id_volontario = -1;
    public string $provincia='';


    /**
     * Campi di ordinamento
     */
    public string $orderby = "data_inizio, data_fine";
}
