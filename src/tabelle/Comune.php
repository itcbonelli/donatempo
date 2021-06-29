<?php

namespace itcbonelli\donatempo\tabelle;
use itcbonelli\donatempo\Notifica;
use \PDO, \DateTime, \Exception;

/**
 * Record comune
 */
class Comune
{

    /**
     * Codice identificativo comune
     */
    public $id_comune;

    /**
     * Denominazione comune
     */
    public $denominazione;

    /**
     * Sigla provincia
     */
    public $provincia;

    /**
     * Identificativo area geografica (zona)
     * @var int
     */
    public $id_area;

    /**
     * Longitudine del comune
     * @var double
     */
    public $longitudine;

    /**
     * Latitudine del comune
     * @var double
     */
    public $latitudine;


    /**
     * Salva le modifiche apportate al record
     * @return bool esito dell'operazione
     */
    public function salva()
    {
        $errori = $this->convalida();
        //se sono presenti errori di convalida
        if (count($errori) > 0) {
            //esco dalla funzione
            return false;
        }

        global $dbconn;

        $id_comune = addslashes($this->id_comune);
        $denominazione = addslashes($this->denominazione);
        $provincia = addslashes($this->provincia);
        $id_area = $this->id_area;
        $lat = $this->latitudine;
        $lng = $this->longitudine;

        $query = "REPLACE INTO comuni(id_comune, denominazione, provincia, id_area, latitudine, longitudine)
        VALUES ('$id_comune', '$denominazione', '$provincia', $id_area, $lat, $lng)";
        $comando = $dbconn->prepare($query);
        $esegui = $comando->execute();
        if ($esegui == true && $comando->rowCount() == 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Convalida i dati per il salvataggio
     * @return string[] array di messaggi di errore della convalida. Se vuoto significa che la convalida è andata a buon fine.
     */
    public function convalida()
    {
        $errori = [];

        if (empty($this->id_comune)) {
            $errori[] = "Inserire identificativo comune";
        }
        if (empty($this->denominazione)) {
            $errori[] = "Inserire denominazione";
        }
        if (strlen($this->provincia) != 2) {
            $errori[] = "Sigla provincia non valida";
        }

        return $errori;
    }

    /**
     * Elimina il record
     * @return bool esito dell'operazione
     */
    public function elimina()
    {
        global $dbconn;
        $query = "DELETE FROM comuni WHERE id_comune='{$this->id_comune}'";
        $comando = $dbconn->prepare($query);
        $esegui = $comando->execute();
        return $esegui == true && $comando->rowCount() == 1;
    }

    /**
     * Determina se esiste un comune con l'ID corrente
     * @return bool true se il comune con il codice esiste, false in caso contrario
     */
    public function esiste()
    {
        global $dbconn;
        $query = "SELECT * FROM comuni WHERE id_comune='{$this->id_comune}'";
        $comando = $dbconn->prepare($query);
        $esegui = $comando->execute();

        return ($esegui == true && $comando->fetch(PDO::FETCH_ASSOC) == true);
    }

    /**
     * Carica i dati del record dal database
     * @return bool esito dell'operazione
     */
    public function carica($id)
    {
        global $dbconn;

        $query = "SELECT * FROM comuni WHERE id_comune='$id'";
        $comando = $dbconn->prepare($query);
        $esegui = $comando->execute();

        if ($esegui == true && $riga = $comando->fetch(PDO::FETCH_ASSOC)) {

            $this->id_comune = $riga['id_comune'];
            $this->denominazione = $riga['denominazione'];
            $this->provincia = $riga['provincia'];
            $this->id_area = $riga['id_area'];
            $this->latitudine = $riga['latitudine'];
            $this->longitudine = $riga['longitudine'];

            return true;
        } else {
            return false;
        }
    }

    /**
     * Ottiene l'elenco dei comuni
     * @param string $prov filtro provincia. Se omesso, restituisce tutti i comuni italiani.
     * @param boolean $tutti include i comuni disattivati
     * @return Comune[] array di comuni
     */
    public static function getElencoComuni($prov = null, $tutti=false)
    {   
        $comuni = [];
        //popolare l'array
        global $dbconn;

        $query = "SELECT * FROM comuni WHERE 1=1 ";
        if($tutti==false) {
            $query .= " AND attivo=1 ";
        }
        if ($prov != null) {
            $prov = addslashes($prov);
            $query .= " AND provincia = '$prov' ";
        }
        $query .= " ORDER BY denominazione ";

        $comando = $dbconn->prepare($query);
        $esegui = $comando->execute();

        if ($esegui == true) {
            while ($riga = $comando->fetch()) {
                $comune = new Comune();
                $comune->id_comune = $riga['id_comune'];
                $comune->denominazione = $riga['denominazione'];
                $comune->provincia = $riga['provincia'];
                $comune->id_area = $riga['id_area'];
                $comune->longitudine = $riga['longitudine'];
                $comune->latitudine = $riga['latitudine'];
                $comuni[] = $comune;
            }
        }

        return $comuni;
    }

    public function getProvincia() {
        return self::getProvinciaComune($this->provincia);
    }

    public static function getProvinciaComune($cod) {
        $prov = new Provincia();
        $prov->carica($cod);
        return $prov;
    }
}