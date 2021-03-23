<?php
namespace itcbonelli\donatempo\tabelle;

/**
 * Record stato di avanzamento richiesta
 */
class StatoAvanzamento {
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
     * @return StatoAvanzamento[]
     */
    public static function elencoStatiAvanzamento() {
        global $dbconn;
        $dataset=[];
        $query="SELECT * FROM stato_richiesta ORDER BY ordine_vis";
        $comando=$dbconn->prepare($query);
        $esegui = $comando->execute();
        if($esegui) {
            while($riga=$comando->fetch()) {
                $record=new StatoAvanzamento();
                $record->codice=$riga['codice'];
                $record->descrizione=$riga['descrizione'];
                $record->ordine_vis=$riga['ordine_vis'];
                $dataset[] = $record;
            }
        }
        return $dataset;
    }
}