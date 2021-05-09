<?php

namespace itcbonelli\donatempo\tabelle;

use itcbonelli\donatempo\AiutoDB;
use PDO;

/**
 * Rappresenta una zona geografica
 */
class Zona
{
    /**
     * Identificativo zona
     */
    public $id_zona;

    /**
     * Denominazione zona geografica
     */
    public $denominazione;

    /**
     * Ottiene l'elenco di tutte le zone
     * @return Zona[]
     */
    public static function ElencoZone(): array
    {
        global $dbconn;
        $dataset = [];
        $q = "SELECT * FROM `zone` ORDER BY denominazione ASC";
        $c = $dbconn->prepare($q);
        $x = $c->execute();
        if ($x) {
            while ($r = $c->fetch(PDO::FETCH_ASSOC)) {
                $z = new Zona();
                $z->id_zona = $r['id_zona'];
                $z->denominazione = $r['denominazione'];
                $dataset[] = $z;
            }
        }
        return $dataset;
    }

    /**
     * Carica un record di zona
     * @param int $id_zona identificativo da caricare
     */
    public function carica(int $id_zona)
    {
        global $dbconn;
        $adb = new AiutoDB($dbconn);
        if ($records = $adb->eseguiQuery("SELECT * FROM `zone` WHERE id_zona='{$id_zona}'")) {
            $record = $records[0];
            $this->id_zona = $record['id_zona'];
            $this->denominazione = $record['denominazione'];
            return true;
        }
        return false;
    }

    /**
     * Ottiene l'elenco dei comuni compresi nella zona considerata
     */
    public function getComuni()
    {
        $dataset = [];
        
    }

    /**
     * Aggiunge un comune alla zona geografica
     * @param string $cod_comune codice catastale comune
     */
    public function aggiungiComune($cod_comune)
    {
    }

    /**
     * Rimuove un comune dalla zona geografica
     * @param string $cod_comune codice catastale comune
     */
    public function rimuoviComune($cod_comune)
    {
    }
}
