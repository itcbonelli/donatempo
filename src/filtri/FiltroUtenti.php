<?php

namespace itcbonelli\donatempo\filtri;

class FiltroUtenti extends FiltroBase
{


    /**
     * Stringa da cercare nei campi testo
     */
    public string $cerca = "";

    /**
     * Se impostato a true o a false mostra solo gli utenti attivi / inattivi
     */
    public ?bool $attivi = null;

 

    /**
     * Campi di ordinamento
     */
    public string $orderby = "username";



}
