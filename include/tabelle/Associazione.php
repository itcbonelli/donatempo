<?php

/**
 * Record associazione
 */
class Associazione
{
    /**
     * Identificativo associazione
     */
    public $id_associazione;

    /**
     * Ragione sociale
     */
    public $ragsoc;

    /**
     * Codice fiscale
     */
    public $codfis;

    /**
     * URL dell'immagine del logo
     */
    public $url_logo;

    /**
     * Descrizione dell'associazione
     * @var string
     */
    public $descrizione;

    /**
     * Codici dei settori in cui opera l'associazione
     */
    public $settori = [];

    /**
     * Salva le modifiche apportate al record
     * @return bool esito dell'operazione
     */
    public function salva()
    {
    }

    /**
     * Carica i dati del record dal database
     * @return bool esito dell'operazione
     */
    public function carica($id_associazione)
    {
    }

    /**
     * Elimina il record
     * @return bool esito dell'operazione
     */
    public function elimina()
    {
    }

    /**
     * Convalida i dati dell'associazione per il salvataggio
     * @return string[] array di messaggi di errore della convalida. Se vuoto significa che la convalida è andata a buon fine.
     */
    public function convalida()
    {
        $errori = [];
        $avvertenze = [];

        if (empty($this->id_associazione)) {
            $errori[] = "Inserire identificativo associazione";
        }
        if (empty($this->ragsoc)) {
            $errori[] = "Inserire ragione sociale";
        }
        if (strlen($this->codfis) != 11) {
            $errori[] = "Codice fiscale non valido. La lunghezza deve essere di 11 cifre";
        }
         if (empty($this->url_logo)) {
            $errori[] = "Ricordati di inserire il logo";
        } 
        if (empty($this->descrizione)) {
            $errori[] = "Ricordati di mettere una descrizione";
        }

        return $errori;
        return $avvertenze;
        // avvertenze non vieta di continuare la registrazione ma ricorda che ci sono dei campi vuoti
    }

    /**
     * Associa un settore all'associazione
     * @param int $id_settore identificativo del settore da associare
     * @return bool esito dell'operazione
     */
    public function associaSettore($id_settore) {

    }

    /**
     * Dissocia un settore all'associazione
     * @param int $id_settore identificativo settore
     * @return bool esito dell'operazione
     */
    public function dissociaSettore($id_settore) {
        
    }

    /**
     * Elimina l'associazione tra servizio e associazione
     * @param int $id_servizio codice del servizio da dissociare dall'associazione corrente
     * @return boolean esito dell'operazione
     */
    public function dissociaServizio($id_servizio) {
        global $dbconn;
		
        $id_associazione=$this->id_associazione;

	    $query="DELETE FROM associazione_offre_servizio
		    WHERE id_associazione=$id_associazione AND id_servizio=$id_servizio";
	    $comando = $dbconn->prepare($query);
	    $esegui = $comando->execute();
	    return $esegui == true && $comando->rowCount() == 1;
    }

    /**
     * Crea l'associazione tra servizio e associazione
     * @param int $id_servizio codice del servizio da associare all'associazione corrente
     * @return boolean esito dell'operazione
     */
    public function associaServizio($id_servizio) {

    }

    

    
}
