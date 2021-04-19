<?php

namespace itcbonelli\donatempo\tabelle;

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
     * Ottiene l'elenco dei comuni compresi nella zona considerata
     */
    public function getComuni()
    {
        $dataset=[];
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
