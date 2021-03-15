<?php

class Settore {
    public $id_settore=null;
    public $nome;

    /**
     * Determina se esiste un settore con l'ID preso in input
     * @param int $id_settore
     * @return boolean
     */
    public static function esiste($id_settore) {

    }
    
    /**
     * Salva le modifiche del record
     * @author Cometto Carola
     * @return boolean esito operazione
     */
    public function salva() {
        global $dbconn;

        $id_settore = $this->id_settore;
        $nome = addslashes($this->nome);

        if(empty($id_settore)) {
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
     * @return boolean esito operazione
     */
    public function elimina() {

    }

    /**
     * Carica i dati del record
     * @param int $id_settore
     * @return boolean esito operazione
     */
    public function carica($id_settore) {

    }
}