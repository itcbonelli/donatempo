<?php

namespace itcbonelli\donatempo\tabelle;

use PDO;

class Zona {
    public $id_zona;
    public $denominazione;

    /**
     * Ottiene l'elenco di tutte le zone
     * @return Zona[]
     */
    public static function ElencoZone():array {
        global $dbconn;
        $dataset=[];
        $q="SELECT * FROM `zone` ORDER BY denominazione ASC";
        $c=$dbconn->prepare($q);
        $x=$c->execute();
        if($x) {
            while($r=$c->fetch(PDO::FETCH_ASSOC)) {
                $z=new Zona();
                $z->id_zona=$r['id_zona'];
                $z->denominazione=$r['denominazione'];
                $dataset[] = $z;
            }
        }
        return $dataset;
    }

    public function getComuni() {

    }

    public function aggiungiComune($cod_comune) {

    }

    public function rimuoviComune($cod_comune) {

    }
}