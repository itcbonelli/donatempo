<?php

namespace itcbonelli\donatempo\tabelle;

use itcbonelli\donatempo\AiutoDB;

/**
 * Record stato di avanzamento richiesta
 */
class StatoAvanzamento
{
    private string $codiceOld = "";

    /**
     * Codice di stato
     */
    public string $codice;

    /**
     * Descrizione
     */
    public string $descrizione;

    /**
     * Ordine di visualizzazione
     */
    public int $ordine_vis;

    /**
     * Ottiene l'elenco di tutti gli stati di avanzamento
     * @return StatoAvanzamento[]
     */
    public static function ElencoStatiAvanzamento()
    {
        global $dbconn;
        $dataset = [];
        $query = "SELECT * FROM stato_richiesta ORDER BY ordine_vis";
        $comando = $dbconn->prepare($query);
        $esegui = $comando->execute();
        if ($esegui) {
            while ($riga = $comando->fetch()) {
                $record = new StatoAvanzamento();
                $record->codice = $riga['codice'];
                $record->descrizione = $riga['descrizione'];
                $record->ordine_vis = $riga['ordine_vis'];
                $dataset[] = $record;
            }
        }
        return $dataset;
    }

    /**
     * Carica il record dal database
     */
    public function carica(string $cod)
    {
        global $dbconn;
        $adb = new AiutoDB($dbconn);
        $record = $adb->eseguiQuery("SELECT * FROM stati_avanzamento WHERE codice=`$cod`");
        if (count($cod) > 0) {
            $this->codice = $record[0]['codice'];
            $this->codiceOld = $record[0]['codice'];
            $this->descrizione = $record[0]['descrizione'];
            $this->ordine_vis = $record[0]['ordine_vis'];
        }
    }

    /**
     * Salva il record nel database
     * @return bool Esito dell'operazione
     */
    public function salva()
    {
        global $dbconn;
        $ris = null;
        $adb = new AiutoDB($dbconn);

        if (empty($this->codiceOld)) {
            $record = [
                'codice' => $this->codice,
                'descrizione' => $this->descrizione,
                'ordine_vis' => $this->ordine_vis
            ];
            $ris = $adb->inserisci("stati_avanzamento", $record, "id");
        } else {
            $ris = $adb->aggiorna("stati_avanzamento", [
                'codice' => $this->codice,
                'descrizione' => $this->descrizione,
                'ordine_vis' => $this->ordine_vis
            ], "codice = `{$this->codiceOld}`");
        }
        return boolval($ris);
    }
}
