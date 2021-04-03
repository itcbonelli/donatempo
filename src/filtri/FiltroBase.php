<?php

namespace itcbonelli\donatempo\filtri;

/**
 * Implementa le funzionalità di base per un filtro di dati con funzioni di paginazione
 */
class FiltroBase
{
    /**
     * Numero di record restituiti dal filtro
     * Questa proprietà viene impostata dalla funzione che esegue la query e serve a gestire la paginazione.
     */
    public ?int $numeroRecord = null;

    /**
     * Numero di righe restituite dalla query
     */
    public int $limite = 24;

    /**
     * Offset del primo record da restituire
     */
    public int $offset = 0;

    /**
     * Ottiene il numero di pagine del record corrente
     */
    public function getNumeroPagine(): int
    {
        return ceil($this->numeroRecord / $this->limite);
    }

    /**
     * Ottiene il numero della pagina corrente
     */
    public function getPaginaCorrente()
    {
        return ceil($this->offset / $this->limite);
    }
}
