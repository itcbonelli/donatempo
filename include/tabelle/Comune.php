<?php

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
        /*
        if($esegui==true) {
            $riga=$comando->fetch();
            return($riga==true);
        } else {
            return false;
        }*/
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
     * @return Comune[] array di comuni
     */
    public static function getElencoComuni($prov = null)
    {
        $comuni = [];
        //popolare l'array
        global $dbconn;

        $query = "SELECT * FROM comuni";
        if ($prov != null) {
            $prov = addslashes($prov);
            $query .= " WHERE provincia = '$prov' ";
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
}

/*
$comuni_cn = Comune::getElencoComuni("CN");
for ($i = 0; $i < count($comuni_cn); $i++) {
    $comune = $comuni_cn[$i];
    echo $comune->denominazione;
}

echo json_encode($comuni_cn);

foreach ($comuni_cn as $comune) {
    echo $comune->denominazione;
    echo $comune->latitudine;
    echo $comune->id_area;
}

//esempi
$cuneo = new Comune();
$torino = new Comune();
$cuneo->carica("D205");
$torino->carica("L219");
echo $cuneo->denominazione; //fa uscire la scritta "Cuneo"
echo $torino->denominazione; // Torino

$nuovocomune = new Comune();
$nuovocomune->id_comune = 'X123';
$nuovocomune->denominazione = 'Roccagialla';
$nuovocomune->provincia = 'BO';
$nuovocomune->salva();
*/