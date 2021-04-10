<?php

namespace itcbonelli\donatempo;

use DateTime;
use PDO;
use RuntimeException;

/**
 * Funzioni rapide per l'esecuzione di query sul database
 * @author Federico Flecchia <federico.flecchia@outlook.com>
 */
class AiutoDB
{
    private PDO $dbconn;

    public function __construct(PDO $dbconn)
    {
        $this->dbconn = $dbconn;
    }

    /**
     * Esegue un comando di tipo non-query (esempio: istruzioni insert/update/delete)
     * @param string $comando Comando da eseguire
     * @param array $parametri Parametri da utilizzare nella query
     * @return int numero di righe inserite, modificate o eliminate. Null in caso di errori
     */
    public function eseguiComando(string $comando, array $parametri = []): ?int
    {
        $comando = $this->dbconn->prepare($comando);
        $esegui = $comando->execute($parametri);
        if ($esegui) {
            return $comando->rowCount();
        } else {
            return null;
        }
    }

    /**
     * Esegue una query SQL e restituisce il suo dataset
     * @param string $query Query SQL da eseguire
     * @param array $parametri Parametri da utilizzare nella query
     * @return array dataset restituito dalla query sotto forma di array associativo
     */
    public function eseguiQuery(string $query, array $parametri = [])
    {
        $comando = $this->dbconn->prepare($query);
        $esegui = $comando->execute($parametri);
        if ($esegui) {
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return [];
        }
    }

    /**
     * Esegue una query SQL che restituisce un unico valore
     * @param string $query Query SQL da eseguire
     * @param array $parametri Parametri da utilizzare nella query
     * @return mixed valore restituito dalla query, null in caso di errori
     */
    public function eseguiScalare(string $query, array $parametri = [])
    {
        $comando = $this->dbconn->prepare($query);
        $esegui = $comando->execute($parametri);
        if ($esegui) {
            return $comando->fetchColumn();
        } else {
            return null;
        }
    }

    /**
     * Inserisce un record nel database operando le opportune correzioni in base ai tipi di dati.
     * @param string $tabella nome della tabella in cui dovrà essere inserito il record
     * @param array $record array associativo contenente i valori del record da inserire. 
     *      Questa variabile viene passata per referenza affinché il valore possa essere aggiornato.
     *      Gli indici dell'array corrispondono ai nomi delle colonne in cui inserire dati.
     *      I valori vengono convertiti all'interno della query a seconda del tipo di variabile.
     *      I tipi ammessi sono string|integer|double|object(DateTime)|boolean.
     *      Se il tipo è stringa verrà eseguito l'escape dei caratteri speciali. Nel caso ciò non sia voluto, anteporre al valore il prefisso raw:, 
     *      in tal modo la stringa sarà gestita letteralmente
     * @param string $cp nome del campo chiave primaria da aggiornare con l'ID generato automaticamente. Tale valore sarà aggiunto alla variabile $record.
     * @return int numero di righe inserite
     * @throws RuntimeException se vengono passati in $record dati il cui tipo non rientra tra quelli ammessi
     */
    public function inserisci(string $tabella, array &$record, string $cp = "")
    {

        $campi = "";
        $valori = "";
        foreach ($record as $c => $v) {
            if (strlen($c) > 0) {
                $campi .= ", ";
                $valori .= ", ";
            }

            $campi .= "`{$c}`";

            $tipoval = gettype($v);
            switch ($tipoval) {
                case 'string':
                    if (str_starts_with($v, 'raw:')) {
                        $v = str_replace('raw:', '', $v);
                        $valori .= $v;
                    } else {
                        $v = addslashes($v);
                        $v = str_replace("`", "\\`", $v);
                        $valori .= "`{$v}`";
                    }
                    break;
                case 'integer':
                case 'double':
                    $valori .= $v;
                    break;
                case 'boolean':
                    $valori .= intval($v);
                    break;
                case 'object':
                    if ($v instanceof DateTime) {
                        $valori .= "'" . $v->format('Y-m-d H:i:s') . "'";
                    }
                    break;
                default:
                    throw new RuntimeException("Tipo {$tipoval} non ammesso");
                    break;
            }
        }

        $sql = "INSERT INTO `$tabella` ($campi) VALUES ($valori)";
        
        $this->eseguiComando($sql);

        if (!empty($cp)) {
            $record[$cp] = $this->dbconn->lastInsertId();
        }
    }

    /**
     * Aggiorna un record nel database operando le opportune correzioni in base ai tipi di dati.
     * @param string $tabella nome della tabella in cui dovrà essere inserito il record
     * @param array $record array associativo contenente i valori del record da inserire. 
     *      Questa variabile viene passata per referenza affinché il valore possa essere aggiornato.
     *      Gli indici dell'array corrispondono ai nomi delle colonne in cui inserire dati.
     *      I valori vengono convertiti all'interno della query a seconda del tipo di variabile.
     *      I tipi ammessi sono string|integer|double|object(DateTime)|boolean.
     *      Se il tipo è stringa verrà eseguito l'escape dei caratteri speciali. Nel caso ciò non sia voluto, anteporre al valore il prefisso raw:, 
     *      in tal modo la stringa sarà gestita letteralmente
     * @param string $cp nome del campo chiave primaria da aggiornare con l'ID generato automaticamente. Tale valore sarà aggiunto alla variabile $record.
     * @return int numero di righe aggiornate
     * @throws RuntimeException se vengono passati in $record dati il cui tipo non rientra tra quelli ammessi
     */
    public function aggiorna(string $tabella, array $record, string $where)
    {
        $query = "UPDATE `{$tabella}` SET ";
        $i = 0;
        foreach ($record as $c => $v) {
            if ($i > 0) {
                $query .= ", ";
            }
            $query .= "\n`{$c}`=";
            $tipoval = gettype($v);
            switch ($tipoval) {
                case 'string':
                    if (str_starts_with($v, 'raw:')) {
                        $v = str_replace('raw:', '', $v);
                        $query .= $v;
                    } else {
                        $v = addslashes($v);
                        $v = str_replace("`", "\\`", $v);
                        $query .= "`{$v}`";
                    }
                    break;
                case 'integer':
                case 'double':
                    $query .= $v;
                    break;
                case 'boolean':
                    $query .= intval($v);
                    break;
                case 'object':
                    if ($v instanceof DateTime) {
                        $query .= "'" . $v->format('Y-m-d H:i:s') . "'";
                    }
                    break;
                default:
                    throw new RuntimeException("Tipo {$tipoval} non ammesso");
                    break;
            }
        }
        $query .= "\nWHERE $where";
        return $this->eseguiComando($query);
    }
}
