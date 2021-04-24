<?php

namespace itcbonelli\donatempo\tabelle;

use itcbonelli\donatempo\AiutoDB;

class Badge
{

    public int $id_badge = -1;
    public string $nome = "";
    public string $url_immagine = "";
    public string $descrizione = "";
    public bool $attivo = true;

    /**
     * Salva il record
     */
    public function salva()
    {
        global $dbconn;
        $adb = new AiutoDB($dbconn);
        $record = [
            'nome' => $this->nome,
            'url_immagine' => $this->url_immagine,
            'descrizione' => $this->descrizione,
            'attivo' => boolval($this->attivo)
        ];
        if ($this->id_badge > 0) {
            $adb->aggiorna('badge', $record, "id_badge={$this->id_badge}");
        } else {
            $adb->inserisci('badge', $record, 'id_badge');
            $this->id_badge = $record['id_badge'];
        }
    }

    /**
     * Carica i dati del record
     * @param int $id identificativo badge
     */
    public function carica($id)
    {
        global $dbconn;
        $adb = new AiutoDB($dbconn);
        $record = $adb->eseguiQuery("SELECT * FROM badge WHERE id_badge=:id", ['id' => $id]);
        if (!empty($record)) {
            $this->id_badge = $record[0]['id_badge'];
            $this->nome = strval($record[0]['nome']);
            $this->descrizione = strval($record[0]['descrizione']);
            $this->url_immagine = strval($record[0]['url_immagine']);
            $this->attivo = boolval($record[0]['id_badge']);
        }
    }

    /**
     * Assegna il badge a un utente
     * @param int $id_utente identificativo utente
     */
    public function assegna($id_utente)
    {
        global $dbconn;
        $adb = new AiutoDB($dbconn);
        $ris = $adb->eseguiComando("INSERT IGNORE INTO utente_riceve_badge (id_badge, id_utente) VALUES (:idb, :idu)", [$this->id_badge, $id_utente]);
        return $ris > 0;
    }

    /**
     * Elimina il record
     * @return bool
     */
    public function elimina()
    {
        global $dbconn;
        $adb = new AiutoDB($dbconn);
        return boolval($adb->eseguiComando("DELETE FROM badge WHERE id_badge=:id", ['id' => $this->id_badge]));
    }

    /**
     * Ottiene l'elenco dei badge
     * @return Badge[]
     */
    public static function elenco()
    {
        global $dbconn;
        $adb = new AiutoDB($dbconn);
        $dataset = [];
        $dati = $adb->eseguiQuery("SELECT * FROM badge");
        foreach ($dati as $riga) {
            $b = new Badge();
            $b->id_badge = $riga['id_badge'];
            $b->nome = strval($riga['nome']);
            $b->descrizione = strval($riga['descrizione']);
            $b->attivo = boolval($riga['attivo']);
            $b->url_immagine = strval($riga['url_immagine']);

            $dataset[] = $b;
        }

        return $dataset;
    }
}
