<?php

/**
 * Tabella provincia
 */
class Provincia
{
    /**
     * Sigla della provincia
     */
    public $sigla;

    /**
     * Denominazione
     */
    public $denominazione;

    /**
     * Regione
     */
    public $regione;

    /**
     * Carica i dati della provincia
     * @param string $sigla sigla della provincia
     * @return bool true se la provincia è stata trovata, falso in caso contrario
     */
    public function carica($sigla)
    {
        global $dbconn;
    }

    /**
     * Restituisce l'array di tutte le province
     * @param string $regione eventuale filtro per regione
     * @return Provincia[]
     */
    public static function caricaTutte($regione = null)
    {
        $province = [];
        //eseguire la query.

        //Per ogni riga restituita creare un'istanza di provincia
        $prov = new Provincia();
        //impostare i dati
        //...
        

        $province[] = $prov;
        return $province;
    }

    /**
     * Convalida i dati per il salvataggio
     * @return array messaggi di errore. Se vuoto significa che non sono presenti errori
     */
    public function convalida()
    {
        $errori = [];
        if (strlen($this->sigla) != 2) {
            $errori[] = "Il campo sigla deve essere di due caratteri";
        }
    }

    /**
     * Salva la provincia corrente
     * @return bool esito dell'operazione
     */
    public function salva()
    {
    }

    /**
     * Elimina la provincia corrente
     * @return bool esito dell'operazione
     */
    public function elimina()
    {
    }

    /**
     * Determina se esiste una provincia con la sigla specificata
     * @return bool true se la provincia esiste, false in caso contrario
     */
    public static function esiste($sigla)
    {
    }
}
