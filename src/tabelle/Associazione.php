<?php

namespace itcbonelli\donatempo\tabelle;

use itcbonelli\donatempo\AiutoDB;
use itcbonelli\donatempo\Notifica;
use Normalizer;
use \PDO, \DateTime, \Exception;

/**
 * Record associazione
 */
class Associazione
{

    const DIR_LOGHI = 'uploads/loghi_associazioni';

    /**
     * Identificativo associazione
     */
    public $id_associazione;

    /**
     * Ragione sociale
     */
    public $ragsoc;

    /**
     * Codice fiscale
     */
    public $codfis;

    /**
     * URL dell'immagine del logo
     */
    public $url_logo;

    /**
     * Descrizione dell'associazione
     * @var string
     */
    public $descrizione;

    /**
     * Codici dei settori in cui opera l'associazione
     */
    public $settori = [];

    /**
     * Indica che l'associazione è attiva
     */
    public $attivo = true;

    /**
     * Salva le modifiche apportate al record
     * @author Federica Ricci
     * @return bool esito dell'operazione
     */
    public function salva()
    {
        $convalida = $this->convalida();

        if ($convalida == false) {
            //esco dalla funzione
            return false;
        }

        global $dbconn;

        $id_associazione = $this->id_associazione;
        $ragsoc = addslashes($this->ragsoc);
        $codfis = addslashes($this->codfis);
        $url_logo = addslashes($this->url_logo);
        $descrizione = addslashes($this->descrizione);
        $id_settore = $this->id_settore;
        $attivo = intval($this->attivo);

        if (empty($this->id_associazione)) {
            $query = "INSERT INTO associazioni(ragsoc,codfis,url_logo,descrizione,id_settore)
        VALUES ('$ragsoc',' $codfis',' $url_logo','$descrizione',$id_settore)";
            $comando = $dbconn->prepare($query);
            $esegui = $comando->execute();
        } else {
            $query = "UPDATE associazioni SET 
            ragsoc='$ragsoc',
            codfis='$codfis'
            url_logo='$url_logo',
            descrizione='$descrizione',
            url_logo=$id_settore,
            attivo=$attivo
            WHERE id_associazione=$id_associazione";
            $comando = $dbconn->prepare($query);
            $esegui = $comando->execute();
        }

        if ($esegui == true && $comando->rowCount() == 1) {
            Notifica::accoda("Associazione salvata correttamente", Notifica::TIPO_SUCCESSO);
            return true;
        } else {
            Notifica::accoda("Si è verificato un errore durante il salvataggio", Notifica::TIPO_ERRORE);
            return false;
        }
    }

    /**
     * Carica i dati del record dal database
     * @author Matteo Llozhi
     * @param int $id_associazione
     * @return bool esito dell'operazione
     */
    public function carica(int $id_associazione)
    {
        global $dbconn;
        //id_associazione è un campo numerico, non ci vogliono gli apici
        $query = "select * from associazioni where id_associazione=$id_associazione";
        $comando = $dbconn->prepare($query);
        $esegui = $comando->execute();
        if ($esegui == true && $riga = $comando->fetch(PDO::FETCH_ASSOC)) {
            $this->id_associazione = $riga['id_associazione'];
            $this->ragsoc = $riga['ragsoc'];
            $this->codfis = $riga['codfis'];
            $this->url_logo = $riga['url_logo'];
            $this->descrizione = $riga['descrizione'];
            $this->attivo = boolval($riga['attivo']);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Elimina il record
     * @author Oberto Azzurra
     * @return bool esito dell'operazione
     */
    public function elimina()
    {
        try {
            global $dbconn;
            $db = new AiutoDB($dbconn);
            $ris = $db->eseguiComando("DELETE FROM associazioni WHERE id_associazione={$this->id_associazione}");
            return boolval($ris);
        } catch (Exception $e) {
            Notifica::accoda($e->getMessage(), Notifica::TIPO_ERRORE);
        }
    }

    /**
     * Convalida i dati dell'associazione per il salvataggio
     * @author Olla Simone
     * @return boolean esito della convalida
     */
    public function convalida()
    {
        $dati_validi = true;

        if (empty($this->id_associazione)) {
            Notifica::accoda("Inserire identificativo associazione", Notifica::TIPO_ERRORE);
            $dati_validi = false;
        }
        if (empty($this->ragsoc)) {
            Notifica::accoda("Inserire ragione sociale", Notifica::TIPO_ERRORE);
            $dati_validi = false;
        }
        if (strlen($this->codfis) != 11) {
            Notifica::accoda("Codice fiscale non valido. La lunghezza deve essere di 11 cifre", Notifica::TIPO_ERRORE);
            $dati_validi = false;
        }
        if (empty($this->url_logo)) {
            Notifica::accoda("Ricordati di inserire il logo", Notifica::TIPO_AVVERTENZA);
        }
        if (empty($this->descrizione)) {
            Notifica::accoda("Ricordati di mettere una descrizione", Notifica::TIPO_ERRORE);
            $dati_validi = false;
        }

        return $dati_validi;
    }

    /**
     * Associa un settore all'associazione
     * @param int $id_settore identificativo del settore da associare
     * @return bool esito dell'operazione
     */
    public function associaSettore($id_settore)
    {
    }

    /**
     * Dissocia un settore all'associazione
     * @param int $id_settore identificativo settore
     * @return bool esito dell'operazione
     */
    public function dissociaSettore($id_settore)
    {
    }

    /**
     * Elimina l'associazione tra servizio e associazione
     * @param int $id_servizio codice del servizio da dissociare dall'associazione corrente
     * @return boolean esito dell'operazione
     */
    public function dissociaServizio($id_servizio)
    {
        global $dbconn;

        $id_associazione = $this->id_associazione;

        $query = "DELETE FROM associazione_offre_servizio
		    WHERE id_associazione=$id_associazione AND id_servizio=$id_servizio";
        $comando = $dbconn->prepare($query);
        $esegui = $comando->execute();
        return $esegui == true && $comando->rowCount() == 1;
    }

    /**
     * Crea l'associazione tra servizio e associazione
     * @author Matteo Filippi
     * @param int $id_servizio codice del servizio da associare all'associazione corrente
     * @return boolean esito dell'operazione
     */
    public function associaServizio($id_servizio)
    {
        global $dbconn;
        $id_associazione = $this->id_associazione;
        //$controllo=esisteAssociazioneServizio($id_associazione, $id_servizio);
        //if ($controllo==false) {
        $query = "REPLACE INTO associazione_offre_servizio (id_associazione, id_servizio) 
            VALUES ($id_associazione, $id_servizio);";
        $comando = $dbconn->prepare($query);
        $esegui = $comando->execute();
        return $esegui == true && $comando->rowCount() == 1;
        //} else {
        //return false;
        //}
    }

    /**
     * Ottiene l'elenco di tutte le associazioni
     * @return Associazione[]
     */
    public static function elencoAssociazioni()
    {
        global $dbconn;
        $dataset = [];
        $comando = $dbconn->prepare("SELECT * FROM associazioni ORDER BY ragsoc");
        $esegui = $comando->execute();
        if ($esegui) {
            while ($riga = $comando->fetch(PDO::FETCH_ASSOC)) {
                $assoc = new Associazione();
                $assoc->id_associazione = $riga['id_associazione'];
                $assoc->ragsoc = $riga['ragsoc'];
                $assoc->codfis = $riga['codfis'];
                $assoc->url_logo = $riga['url_logo'];
                $assoc->descrizione = $riga['descrizione'];
                $dataset[] = $assoc;
            }
        }

        return $dataset;
    }

    /**
     * Ottiene l'elenco delle sole associazioni a cui appartiene l'utente corrente
     * @return Associazione[]
     */
    public static function getMieAssociazioni($solo_verificate = true)
    {
        global $dbconn;
        $io = Utente::getMioUtente();
        $dataset = [];

        $sql = "SELECT associazioni.* FROM associazioni 
        INNER JOIN utente_partecipa_associazione AS partecipa ON partecipa.associazioni_id_associazione=associazioni.id_associazione
        WHERE partecipa.utenti_id_utente = {$io->id_utente}";
        if ($solo_verificate) {
            $sql .= " AND confermato=true ";
        }
        $sql .= "ORDER BY ragsoc";

        $comando = $dbconn->prepare($sql);
        $esegui = $comando->execute();
        if ($esegui) {
            while ($riga = $comando->fetch(PDO::FETCH_ASSOC)) {
                $assoc = new Associazione();
                $assoc->id_associazione = $riga['id_associazione'];
                $assoc->ragsoc = $riga['ragsoc'];
                $assoc->codfis = $riga['codfis'];
                $assoc->url_logo = $riga['url_logo'];
                $assoc->descrizione = $riga['descrizione'];
                $dataset[] = $assoc;
            }
        }

        return $dataset;
    }


    /**
     * Determina se l'utente connesso può apportare una modifica al record
     * @return bool restituisce vero se l'utente è autorizzato alla modifica, falso in caso contrario
     */
    public function puoModificare(): bool
    {
        //caso 1: l'utente è un amministratore del portale
        //gli amministratori possono fare tutto
        $utente = Utente::getMioUtente();
        if ($utente->amministratore == true) {
            return true;
        }

        return false;
    }

    /**
     * Determina se l'utente connesso può eliminare il record
     * @return bool restituisce vero se l'utente è autorizzato all'eliminazione del record, falso in caso contrario
     */
    public function puoEliminare(): bool
    {
        //caso 1: l'utente è un amministratore del portale
        //gli amministratori possono fare tutto
        $utente = Utente::getMioUtente();
        if ($utente->amministratore == true) {
            return true;
        }

        //L'associazione può essere eliminata solo da chi l'ha creata


        return false;
    }

    /**
     * Ottiene i settori in cui opera l'associazione
     * @return Settore[]
     */
    public function getSettori()
    {
        global $dbconn;
        $settori = [];
        $adb = new AiutoDB($dbconn);
        $ds = $adb->eseguiQuery("SELECT * FROM `settori_has_associazioni` WHERE associazioni_id_associazione = {$this->id_associazione} ");
        foreach ($ds as $rec) {
            $sett = new Settore();
            $sett->carica($rec['settori_id_settore']);
            $settori[] = $sett;
        }

        return $settori;
    }

    /**
     * Determina se l'associazione ha un logo caricato
     */
    function haLogo() {
        if(empty($this->url_logo)) {
            return false;
        }

        if(!file_exists(__DIR__ . "/../../{$this->url_logo}")) {
            Notifica::accoda('immagine logo inesistente', Notifica::TIPO_AVVERTENZA);
            return false;
        }

        return true;
    }

    /**
     * Carica il logo dell'associazione
     */
    function caricaLogo($nomeCampo) {
        $updir=realpath(__DIR__ . '/../../' . self::DIR_LOGHI);
        if(isset($_FILES[$nomeCampo])) {
            move_uploaded_file($_FILES[$nomeCampo]['tmp_name'], $updir . "/");
        }
    }
}
