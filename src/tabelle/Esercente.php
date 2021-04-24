<?php

namespace itcbonelli\donatempo\tabelle;

use Exception;
use itcbonelli\donatempo\AiutoConvalida;
use itcbonelli\donatempo\AiutoDB;
use itcbonelli\donatempo\Notifica;
use PDO;

class Esercente
{
    public ?int $id_esercente = -1;
    public ?string $nome;
    public ?string $ragsoc;
    public ?string $piva;
    public ?string $cod_comune;
    public ?string $indirizzo;
    public ?string $cap;
    public ?string $descrizione;
    public ?string $logo_url;
    public bool $attivo = true;

    /**
     * Carica il record
     * @author Chesta Giulia
     */
    public function carica(int $id_esercente): bool
    {
        global $dbconn;

        $query = "SELECT * FROM esercenti WHERE id_esercente='$id_esercente'";
        $comando = $dbconn->prepare($query);
        $esegui = $comando->execute();

        if ($esegui == true && $riga = $comando->fetch(PDO::FETCH_ASSOC)) {
            $this->riempiCampi($riga);
            return true;
        } else {
            return false;
        }
    }

    public function salva(): bool
    {
        global $dbconn;
        $adb = new AiutoDB($dbconn);
        $record = [
            'nome' => $this->nome,
            'ragsoc' => $this->ragsoc,
            'piva' => $this->piva,
            'indirizzo' => $this->indirizzo,
            'cap' => $this->cap,
            'cod_comune' => $this->cod_comune,
            'attivo' => $this->attivo
        ];

        if ($this->id_esercente == -1) {
            $ins = $adb->inserisci('esercenti', $record, 'id_esercente');
            if ($ins) {
                $this->id_esercente = $record['id_esercente'];
                return true;
            }
        } else {
            $agg = $adb->aggiorna('esercenti', $record, 'id_esercente=' . $this->id_esercente);
            if ($agg) return true;
        }
        return false;
    }

    /**
     * @author Olla Simone
     */
    public function elimina(): bool
    {
        global $dbconn;
        $query = "DELETE * FROM esercente WHERE id_esercente='{$this->id_esercente}'";
        $comando = $dbconn->prepare($query);
        $esegui = $comando->execute();
        return $esegui == true && $comando->rowCount() == 1;
    }

    /**
     * @author Lucia Tosello
     */
    public function convalida(): bool
    {
        $ris = true;

        if (AiutoConvalida::LunghezzaTesto($this->nome, "Il nome dell'esercizio deve essere di lunghezza compresa tra 1 e 50", 1, 50)) {
            Notifica::accoda("Inserire nome", Notifica::TIPO_ERRORE);
            $ris = false;
        }

        return $ris;
    }


    /**
     * @return Esercente[]
     */
    public static function ElencoEsercenti()
    {
        global $dbconn;
        $dataset = [];
        $query = "SELECT * FROM esercenti ORDER BY nome";
        $comando = $dbconn->prepare($query);
        $esegui = $comando->execute();
        if ($esegui) {
            while ($riga = $comando->fetch(PDO::FETCH_ASSOC)) {
                $esercente = new Esercente();
                $esercente->riempiCampi($riga);
                $dataset[]=$esercente;
            }
        }

        return $dataset;
    }

    public function riempiCampi($riga)
    {
        $this->id_esercente = intval($riga['id_esercente']);
        $this->nome = strval($riga['nome']);
        $this->ragsoc = strval($riga['ragsoc']);
        $this->piva = strval($riga['piva']);
        $this->cod_comune = strval($riga['cod_comune']);
        $this->indirizzo = strval($riga['indirizzo']);
        $this->cap = strval($riga['cap']);
        $this->descrizione = strval($riga['descrizione']);
        $this->logo_url = strval($riga['logo_url']);
        $this->attivo = boolval($riga['attivo']);
    }
}
