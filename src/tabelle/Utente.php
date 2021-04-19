<?php

namespace itcbonelli\donatempo\tabelle;

use itcbonelli\donatempo\AiutoConvalida;
use itcbonelli\donatempo\AiutoDB;
use itcbonelli\donatempo\filtri\FiltroUtenti;
use itcbonelli\donatempo\Notifica;
use \PDO, \DateTime, \Exception;
use PHPMailer\PHPMailer\PHPMailer;

/**
 * Record utente
 */
class Utente
{
    /**
     * Identificativo
     */
    public ?int $id_utente = null;

    /**
     * Nome utente
     */
    public string $username = "";

    /**
     * Password da impostare (in chiaro)
     */
    public string $password = "";

    /**
     * Data e ora di creazione dell'utente
     */
    public ?DateTime $data_creazione = null;

    /**
     * Data e ora dell'ultimo accesso
     */
    public ?DateTime $ultimo_accesso = null;

    /**
     * Indirizzo e-mail
     */
    public string $email = "";

    /**
     * Attivo sì/no
     */
    public bool $attivo = true;

    /**
     * Eliminato sì/no
     */
    public bool $eliminato = false;

    /**
     * Data di eliminazione del profilo
     */
    public ?DateTime $data_eliminazione = null;

    /**
     * Numero di telefono
     */
    public string $telefono = "";

    /**
     * Volontario sì/no
     */
    public bool $volontario = false;

    /**
     * Amministratore sì/no
     */
    public bool $amministratore = false;

    /**
     * Codice di recupero della mail
     */
    public string $codice_recupero = "";

    /**
     * Salva il record nel database
     * @author Francesco Miglietti
     * @return bool esito dell'operazione
     */
    public function salva()
    {
        if (!$this->convalida()) {
            return false;
        }

        global $dbconn;
        $id_utente = $this->id_utente;
        $username = addslashes($this->username);
        $password = $this->password;
        $data_creazione = $this->data_creazione;
        $ultimo_accesso = $this->ultimo_accesso;
        $email = addslashes($this->email);
        $attivo = intval($this->attivo); // il campo boolean in mysql è rappresentato come un intero 1 o 0
        $eliminato = intval($this->eliminato); // il campo boolean in mysql è rappresentato come un intero 1 o 0
        $data_eliminazione = $this->data_eliminazione;
        $telefono = addslashes($this->telefono);
        $volontario = intval($this->volontario);
        $amministratore = intval($this->amministratore);

        if (empty($this->id_utente)) {
            $password = hash('sha256', $password);
            $query = "INSERT INTO utenti(username, `password`, data_creazione, email, attivo, telefono, volontario, amministratore)
            VALUES ('$username', '$password', '$data_creazione', '$email', $attivo, '$telefono', '$volontario', $amministratore)";
            $comando = $dbconn->prepare($query);
            $esegui = $comando->execute();
            //rowCount()==1 ci dice il numero di righe che sono state coinvolte nell'operazione
            if ($esegui == true && $comando->rowCount() == 1) {
                $this->id_utente = $dbconn->lastInsertId();
                return true;
            } else {
                return false;
            }
        } else {
            $query = "UPDATE utenti SET 
                username='$username',
                `password`='$password',
                email='$email',
                attivo=$attivo,
                telefono='$telefono',
                volontario=$volontario,
                amministratore=$amministratore
            WHERE id_utente=$id_utente";
        }
    }

    /**
     * Carica i dati del record
     * @author Francesco Miglietti
     * @param int $id_utente identificativo utente
     * @return bool esito operazione
     */
    public function carica($id_utente)
    {
        global $dbconn;
        $query = "SELECT * FROM utenti WHERE id_utente=$id_utente";
        $comando = $dbconn->prepare($query);
        $esegui = $comando->execute();
        if ($esegui == true && $riga = $comando->fetch(PDO::FETCH_ASSOC)) {
            $this->riempiCampi($riga);
            return true;
        } else {
            return false;
        }
    }



    /**
     * Determina se esistono utente e password ed imposta 
     * le opportune variabili di sessione
     * @param string $username nome utente
     * @param string $password password
     * @return Utente oggetto utente a cui corrispondono le credenziali o null se non esiste
     */
    public static function login($username, $password)
    {
        global $dbconn;
        $adb = new AiutoDB($dbconn);

        $username = addslashes($username);
        $password = hash('sha256', $password);

        $query = "SELECT * FROM utenti WHERE username='$username' AND password='$password'";
        $comando = $dbconn->prepare($query);
        $esegui = $comando->execute();

        if ($esegui == true && $riga = $comando->fetch(PDO::FETCH_ASSOC)) {
            $_SESSION['id_utente'] = $riga['id_utente'];
            $_SESSION['username'] = $riga['username'];

            $utente=new Utente();
            $utente->carica($riga['id_utente']);

            //aggiorno la data ultimo accesso
            $adb->eseguiComando("UPDATE utenti SET ultimo_accesso=current_timestamp WHERE id_utente=:id_utente", ['id_utente' => $riga['id_utente']]);

            return $utente;
        } else {
            Notifica::accoda("Dati di accesso non validi", Notifica::TIPO_ERRORE);
            return null;
        }
    }

    /**
     * Disconnette l'utente dal sito
     */
    public static function Logout(): bool
    {
        session_destroy();
        return true;
    }

    /**
     * Controlla se esiste l'ID Utente specificato
     * @author Gaia Barale
     * @param int $id_utente
     * @return bool vero o falso
     */
    public static function esisteId($id_utente): bool
    {
        global $dbconn;
        $query = "SELECT id_utente FROM utenti WHERE id_utente='{$id_utente}'";
        $comando = $dbconn->prepare($query);
        $esegui = $comando->execute();

        return ($esegui == true && $comando->fetch(PDO::FETCH_ASSOC) == true);
    }

    /**
     * Controlla se esiste lo username specificato
     * @author Carola Nerattini
     * @param int $username
     * @return bool vero o falso
     */
    public static function esisteUsername($username): bool
    {
        global $dbconn;
        $username = addslashes($username);
        $query = "SELECT * FROM utenti WHERE username='$username'";
        $comando = $dbconn->prepare($query);
        $esegui = $comando->execute();

        if ($esegui == true) {
            $riga = $comando->fetch();
            return ($riga == true);
        } else {
            return false;
        }
    }



    /**
     * Ottiene il record dell'utente attualmente connesso al sito.
     * Se l'utente non ha eseguito l'accesso restituisce null
     * @return Utente dati dell'utente collegato oppure null se è un ospite
     */
    public static function getMioUtente()
    {
        if (!isset($_SESSION['id_utente'])) {
            return null;
        }
        $utente = new Utente();
        $utente->carica($_SESSION['id_utente']);
        return $utente;
    }

    /**
     * Convalida il record per il salvataggio
     */
    public function convalida(): bool
    {
        $valido = true;

        /*if (empty($this->id_utente)) {
            Notifica::accoda("Inserire identificativo utente", Notifica::TIPO_ERRORE);
            $valido = false;
        }*/

        $valido = $valido && AiutoConvalida::LunghezzaTesto($this->username, "La lunghezza del nome utente deve essere compresa tra 1 e 45 caratteri", 1, 45);
        $valido = $valido && AiutoConvalida::LunghezzaTesto($this->email, "La lunghezza dell'indirizzo e-mail deve essere compresa tra 1 e 100 caratteri", 1, 100);
        $valido = $valido && AiutoConvalida::LunghezzaTesto($this->telefono, "La lunghezza del numero di telefono deve essere compresa tra 1 e 45 caratteri", 1, 45);

        return $valido;
    }


    /**
     * Letti in input nome utente o e-mail di un utente, genera un nuovo codice alfanumerico di recupero password
     * e glielo invia per posta elettronica.
     * @param string $usernameOEmail nome utente o e-mail
     * @return bool esito operazione invio
     */
    public function inviaMailRecuperoPassword($usernameOEmail)
    {
        global $dbconn;
        if (empty($this->id_utente)) {
            Notifica::accoda("Codice utente non specificato", Notifica::TIPO_ERRORE);
            return false;
        }

        $casuale = uniqid("", true);
        $this->codice_recupero = $casuale;
        $esegui = $this->salva();

        if ($esegui == true) {
            $email = $this->email;
            //INVIO DEL MESSAGGIO DI RECUPERO
            $mailer = new PHPMailer(true);
            //imposto indirizzo utente
            $mailer->addAddress($email, $this->username);
            $mailer->Subject = "[DONATEMPO] Recupero password";
            $mailer->ContentType = PHPMailer::CONTENT_TYPE_TEXT_HTML;
            /** @todo predisporre link recupero account */
            $link = "#";

            $strbody = "Ciao, {$this->username}<br />"
                . "Ricevi questa mail perché hai richiesto di reimpostare la password del tuo account su DonaTempo.<br />"
                . "Per impostare una nuova password: <br />"
                . "<a href='{$link}' style='font-size: 24px'>FAI CLIC QUI</a><br />";

            $mailer->Body = $strbody; //corpo del messaggio
            $invia = $mailer->send();
            if ($invia) {
                Notifica::accoda("Controlla la tua casella di posta. Ti abbiamo inviato le istruzioni per recuperare la password del tuo account", Notifica::TIPO_SUCCESSO);
            } else {
                Notifica::accoda("Errore nell'invio del messaggio", Notifica::TIPO_ERRORE);
            }
        } else {
            Notifica::accoda("Ci sono stati problemi con la generazione del codice di recupero", Notifica::TIPO_ERRORE);
            return false;
        }
    }



    /**
     * Reimposta la password del record utente corrente.
     * Modifica la proprietà password con l'hash calcolato della nuova password
     * @param string $nuovaPassword
     * @return bool esito operazione.
     */
    public function reimpostaPassword($nuovaPassword)
    {
    }


    /**
     * Ottiene il profilo dell'utente
     * @author Federico Flecchia
     * @return Profilo
     */
    public function getProfilo()
    {
        if ($this->id == null) {
            return null;
        }
        $pro = new Profilo();
        $pro->carica($this->id_utente);
        return $pro;
    }

    /**
     * Restituisce l'elenco degli utenti
     * @param FiltroUtenti $filtro parametri per filtrare i risultati
     * @return Utente[]
     */
    public static function ElencoUtenti(FiltroUtenti $filtro)
    {

        global $dbconn;
        $dataset = [];

        $query = " SELECT * FROM utenti WHERE 1=1";

        if (!empty($filtro->cerca)) {
            $query .= " AND (username like '%{$filtro->cerca}%' OR  email LIKE '%{$filtro->cerca}%')";
        }
        if ($filtro->attivi != null) {
            $query .= " AND attivo= " . $filtro->attivi ? 1 : 0;
        }

        $query .= " ORDER BY `{$filtro->orderby}` ";
        $query .= " LIMIT {$filtro->offset}, {$filtro->limite} ";
        $comando = $dbconn->prepare($query);
        $esegui = $comando->execute();
        if ($esegui) {
            //print($query);
            while ($riga = $comando->fetch(PDO::FETCH_ASSOC)) {
                $utente = new Utente();
                $utente->riempiCampi($riga);
                $dataset[] = $utente;
            }
        }

        return $dataset;
    }

    /**
     * Carica i dati da un array
     * @param Array $record record proveniente dal database
     */
    public function riempiCampi(array $record)
    {
        $this->id_utente = intval($record['id_utente']);
        $this->username = strval($record['username']);
        $this->password = strval($record['password']);
        $this->data_creazione = new DateTime($record['data_creazione']);
        $this->ultimo_accesso = new DateTime($record['ultimo_accesso']);
        $this->email = strval($record['email']);
        $this->attivo = boolval($record['attivo']);
        $this->eliminato = boolval($record['eliminato']);
        $this->data_eliminazione = new DateTime($record['data_eliminazione']);
        $this->telefono = strval($record['telefono']);
        $this->volontario = boolval($record['volontario']);
        $this->amministratore = boolval($record['amministratore']);
    }

    /**
     * Conta i record presenti nel database
     */
    public static function ContaUtenti(FiltroUtenti $filtro)
    {
        global $dbconn;
        $query = "SELECT COUNT(*) FROM utenti WHERE 1=1 ";
        if (!empty($filtro->cerca)) {
            $query .= " AND (username like '%{$filtro->cerca}%' OR  email LIKE '%{$filtro->cerca}%')";
        }
        if ($filtro->attivi != null) {
            $query .= " AND attivo= " . $filtro->attivi ? 1 : 0;
        }
        $comando = $dbconn->prepare($query);
        $esegui = $comando->execute();

        return intval($comando->fetchColumn());
    }
}
