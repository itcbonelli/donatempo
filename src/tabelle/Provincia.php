<?php

namespace itcbonelli\donatempo\tabelle;

use itcbonelli\donatempo\AiutoDB;
use itcbonelli\donatempo\Notifica;
use \PDO, \DateTime, \Exception;

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
        $query = "SELECT * FROM province WHERE sigla = '$sigla'";
        $comando = $dbconn->prepare($query);
        $esegui = $comando->execute();

        if ($esegui == true && $riga = $comando->fetch(PDO::FETCH_ASSOC)) {

            $this->sigla = $riga['sigla'];
            $this->denominazione = $riga['denominazione'];
            $this->regione = $riga['regione'];
        } else {
            return false;
        }
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

        global $dbconn;
        $query = "SELECT * FROM province";
        if ($regione != null) {
            $regione = addslashes($regione);
            if (!empty($regione)) {
                $query .= " WHERE regione = '$regione' ";
            }
        }
        $query .= " ORDER BY denominazione";

        $comando = $dbconn->prepare($query);
        $esegui = $comando->execute();

        if ($esegui == true) {
            while ($riga = $comando->fetch()) {
                $prov = new Provincia();
                $prov->sigla = $riga['sigla'];
                $prov->denominazione = $riga['denominazione'];
                $prov->regione = $riga['regione'];
                $province[] = $prov;
            }
        }

        return $province;
    }

    /**
     * Convalida i dati per il salvataggio
     * @return array messaggi di errore. Se vuoto significa che non sono presenti errori
     */
    public function convalida()
    {
        $valido = true;
        if (empty($this->denominazione) == true) {
            Notifica::accoda("Inserire la denominazione di provincia", Notifica::TIPO_ERRORE);
            $valido = false;
        }
        if (strlen($this->sigla) != 2) {
            Notifica::accoda("Il campo sigla deve essere di due caratteri", Notifica::TIPO_ERRORE);
            $valido = false;
        }
        return $valido;
    }

    /**
     * Salva la provincia corrente
     * @return bool esito dell'operazione
     */
    public function salva()
    {
        //se sono presenti errori di convalida
        
        if (!$this->convalida()) {
            //esco dalla funzione
            return false;
        }

        global $dbconn;
        $sigla = addslashes($this->sigla);
        $denominazione = addslashes($this->denominazione);
        $regione = addslashes($this->regione);


        $query = "REPLACE INTO province(sigla, denominazione, regione)
		VALUES ('$sigla', '$denominazione', '$regione')";
        $comando = $dbconn->prepare($query);
        $esegui = $comando->execute();
        
        if ($esegui == true && $comando->rowCount()>0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Elimina la provincia corrente
     * @return bool esito dell'operazione
     */
    public function elimina()
    {
        global $dbconn;
		$query = "DELETE FROM province WHERE sigla='{$this->sigla}'";
		$comando = $dbconn->prepare($query);
		$esegui = $comando->execute();
		return $esegui==true && $comando->rowCount() == 1;
    }

    public static function ElencoRegioni() {
        global $dbconn;
        $adb=new AiutoDB($dbconn);
        return $adb->eseguiQuery("SELECT DISTINCT regione FROM province ORDER BY regione");
    }

    /**
     * Determina se esiste una provincia con la sigla specificata
     * @return bool true se la provincia esiste, false in caso contrario
     */
    public static function esiste($sigla)
    {
    }
}
