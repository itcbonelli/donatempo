<?php
namespace itcbonelli\donatempo\tabelle;
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
    public $id_servizio;

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
     * @return bool esito operazione
     */
    public function convalida()
    {
    }

    /**
     * Elimina il servizio corrente
     * @author Alessia Pagliasso
     * @return bool esito operazione
     */
    public function elimina()
    {
        global $dbconn;
        $query = "DELETE FROM servizi WHERE id_servizio='{$this->id_servizio}'";
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
                $servizio->id = $riga['id'];
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
}
