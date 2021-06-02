<?php

namespace itcbonelli\donatempo\tabelle;

use itcbonelli\donatempo\AiutoDB;
use itcbonelli\donatempo\Notifica;
use \PDO, \DateTime, \Exception;

class Settore
{
    public $id_settore = null;
    public $nome;

    /**
     * Determina se esiste un settore con l'ID preso in input
     * @param int $id_settore
     * @return boolean
     */
    public static function esiste($id_settore)
    {
        global $dbconn;
        $dba = new AiutoDB($dbconn);
        return $dba->eseguiScalare("SELECT COUNT(id_settore) FROM settori WHERE id_settore=:id", ['id' => $id_settore]) > 0;
    }

    /**
     * Salva le modifiche del record
     * @author Cometto Carola
     * @return boolean esito operazione
     */
    public function salva()
    {
        global $dbconn;

        $id_settore = $this->id_settore;
        $nome = addslashes($this->nome);

        if (empty($id_settore)) {
            //qua faccio la insert
            $query = "INSERT INTO settori(id_settore, nome)
            VALUES ($id_settore, '$nome')";
            $comando = $dbconn->prepare($query);
            $esegui = $comando->execute();

            $this->id_settore = $dbconn->lastInsertId();
        } else {
            //qua faccio la update
            $query = "UPDATE settori SET nome='$nome' WHERE id_settore=$id_settore";
            $comando = $dbconn->prepare($query);
            $esegui = $comando->execute();
        }

        if ($esegui == true && $comando->rowCount() == 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Elimina il record
     * @author Giulia Chesta
     * @return boolean esito operazione
     */
    public function elimina()
    {
        global $dbconn;
        $query = "DELETE FROM settore WHERE id_settore='{$this->id_settore}'";
        $comando = $dbconn->prepare($query);
        $esegui = $comando->execute();
        return $esegui == true && $comando->rowCount() == 1;
    }

    /**
     * Carica i dati del record
     * @param int $id_settore
     * @return boolean esito operazione
     */
    public function carica($id_settore)
    {
        global $dbconn;
        $adb = new AiutoDB($dbconn);

        $dati = $adb->eseguiQuery("SELECT * FROM settori WHERE id_settore = :id", ['id' => $id_settore]);
        if(count($dati)) {
            $this->id_settore = $dati[0]['id_settore'];
            $this->nome = $dati[0]['nome'];
            return true;
        }

        return false;
    }


    /**
     * Restituisce l'elenco di tutti i settori
     * @author Beatrice Meinero
     * @return Settore[]
     */
    public static function getElencoSettori()
    {
        global $dbconn;
        $dataset = [];

        $query = "SELECT * FROM settori ORDER BY nome";
        $comando = $dbconn->prepare($query);
        $esegui = $comando->execute();

        if ($esegui == true) {
            while ($riga = $comando->fetch(PDO::FETCH_ASSOC)) {
                $settore = new Settore();
                $settore->id_settore = $riga['id_settore'];
                $settore->nome = $riga['nome'];
                $dataset[] = $settore;
            }
        }

        return $dataset;
    }
}
