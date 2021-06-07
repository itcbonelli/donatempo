<?php

namespace itcbonelli\donatempo\filtri;

use DateTime;

class FiltroRichieste extends FiltroBase
{

    public string $cod_comune = '';
    public ?DateTime $data_inizio = null;
    public ?DateTime $data_fine = null;
    public ?int $id_servizio = null;
    public ?int $id_volontario = null;
    public string $provincia = '';
    public string $statoAvanzamento = '';


    /**
     * Campi di ordinamento
     */
    public string $orderby = "data_inizio, data_fine";
}
