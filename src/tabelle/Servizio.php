<?php

namespace itcbonelli\donatempo\tabelle;

use itcbonelli\donatempo\AiutoDB;
use itcbonelli\donatempo\Notifica;
use \PDO, \DateTime, \Exception;

/**
 * Record servizio
 */
class Servizio
{

    /**
     * Identificativo servizio
     * @var int
     */
    public $id_servizio = -1;

    /**
     * Nome servizio
     * @var string
     */
    public $nome;

    /**
     * Descrizione servizio
     * @var string
     */
    public $descrizione;

    /**
     * Codice tipologia servizio
     * @var int
     */
    public $tipo;

    /**
     * Durata della prestazione
     * @var int
     */
    public $durata;

    /**
     * Servizio attivo (sì/no)
     * @var bool
     */
    public $attivo = true;

    /**
     * Salva il servizio
     * @return bool esito operazione
     */
    public function salva()
    {
        global $dbconn;
        $adb = new AiutoDB($dbconn);
        $record = [];

        $record['nome'] = $this->nome;
        if ($this->tipo != null) {
            $record['id_tipo'] = $this->tipo;
        }
        $record['durata'] = $this->durata;
        $record['attivo'] = intval($this->attivo);
        $record['descrizione'] = $this->descrizione;

        if ($this->id_servizio == -1) {
            $ins = $adb->inserisci('servizi', $record, 'id_servizio');
            if ($ins > 0) {
                $this->id_servizio = $record['id_servizio'];
                return true;
            } else {
                Notifica::accoda("Si è verificato un errore in fase di inserimento del record", Notifica::TIPO_ERRORE);
                return false;
            }
        } else {
            $agg = $adb->aggiorna('servizi', $record, "id=servizio={$this->id_servizio}");
            return ($agg > 0);
        }
    }

    /**
     * Carica il record del servizio
     * @author Samuele Ramonda
     * @param int $id_servizio id servizio da caricare
     * @return bool esito operazione
     */
    public function carica($id_servizio)
    {
        global $dbconn;

        $query = "SELECT * FROM servizi WHERE id=$id_servizio";
        $comando = $dbconn->prepare($query);
        $esegui = $comando->execute();

        if ($esegui == true && $riga = $comando->fetch(\PDO::FETCH_ASSOC)) {
            $this->id_servizio = $riga['id'];
            $this->nome = $riga['nome'];
            $this->descrizione = $riga['descrizione'];
            $this->tipo = $riga['id_tipo'];
            $this->durata = $riga['durata'];
            $this->attivo = boolval($riga['attivo']);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Esegue la convalida dei dati
     * @author Oberto Azzurra
     * @return bool esito operazione
     */
    public function convalida()
    {
        $dati_validi = true;

        if (empty($this->id)) {
            Notifica::accoda("Inserire l'id del servizio", Notifica::TIPO_ERRORE);
            $dati_validi = false;
        }
        if (strlen($this->nome)) {
            Notifica::accoda("Inserire il nome", Notifica::TIPO_ERRORE);
            $dati_validi = false;
        }
        /*if (strlen($this->descrizione)) {
            Notifica::accoda("Impostare una descrizione", Notifica::TIPO_ERRORE);
        }
        if (empty($this->id_tipo)) {
            Notifica::accoda("Inserire il tipo di servizio", Notifica::TIPO_AVVERTENZA);
            $dati_validi = false;
        }
        if (empty($this->durata)) {
            Notifica::accoda("Ricordati di mettere la durata", Notifica::TIPO_ERRORE);
        }
        */

        return $dati_validi;
    }

    /**
     * Elimina il servizio corrente
     * @author Alessia Pagliasso
     * @return bool esito operazione
     */
    public function elimina()
    {
        global $dbconn;
        $query = "DELETE FROM servizi WHERE id='{$this->id_servizio}'";
        $comando = $dbconn->prepare($query);
        $esegui = $comando->execute();
        return $esegui == true && $comando->rowCount() == 1;
    }

    /**
     * Ottiene l'elenco dei servizi disponibili
     * @author Lucia Tosello
     * @param bool $solo_attivi se vale true vengono mostrati solo i servizi attivi
     * @return Servizio[]
     */
    public static function elencoServizi($solo_attivi = true)
    {
        $dataset = [];
        global $dbconn;

        $where = " 1=1 ";

        if ($solo_attivi == true) {
            $where .= " AND attivo=1 ";
        }

        $query = "SELECT * FROM servizi WHERE $where ORDER BY nome";

        $comando = $dbconn->prepare($query);
        $esegui = $comando->execute();

        if ($esegui == true) {
            while ($riga = $comando->fetch()) {
                $servizio = new Servizio();
                $servizio->id_servizio = $riga['id'];
                $servizio->nome = $riga['nome'];
                $servizio->descrizione = $riga['descrizione'];
                $servizio->id_tipo = $riga['id_tipo'];
                $servizio->durata = $riga['durata'];
                $servizio->attivo = boolval($riga['attivo']);
                $dataset[] = $servizio;
            }
        }
        return $dataset;
    }


    /**
     * Popola i campi dell'oggetto con dati provenienti da un array
     * @param array $dati array con i dati
     */
    public function popolaCampi($dati)
    {
        $this->id = $dati['id'];
        $this->nome = $dati['nome'];
        $this->descrizione = $dati['descrizione'];
        $this->durata = $dati['durata'];
        $this->attivo = boolval($dati['attivo']);
        $this->tipo = intval($dati['id_tipo']);
    }
}
