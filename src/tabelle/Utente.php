<?php

namespace itcbonelli\donatempo\tabelle;

use itcbonelli\donatempo\AiutoConvalida;
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
    public int $id_utente;

    /**
     * Nome utente
     */
    public $username;

    /**
     * Password
     */
    public string $password;

    /**
     * Data e ora di creazione dell'utente
     */
    public \DateTime $data_creazione;

    /**
     * Data e ora dell'ultimo accesso
     */
    public \DateTime $ultimo_accesso;

    /**
     * Indirizzo e-mail
     */
    public string $email;

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
    public int $data_eliminazione;

    /**
     * Numero di telefono
     */
    public string $telefono;

    /**
     * Volontario sì/no
     */
    public bool $volontario = false;

    /**
     * Amministratore sì/no
     */
    public bool $amministratore;

    /**
     * Codice di recupero della mail
     */
    public string $codice_recupero;

    /**
     * Salva il record nel database
     * @author Francesco Miglietti
     * @return bool esito dell'operazione
     */
    public function salva()
    {
        $errori = $this->convalida();
        //se sono presenti errori di convalida
        if (count($errori) > 0) {
            //esco dalla funzione
            return false;
        }

        global $dbconn;
        $id_utente = $this->id_utente;
        $username = addslashes($this->username);
        $password = addslashes($this->password);
        $data_creazione = $this->data_creazione;
        $ultimo_accesso = $this->ultimo_accesso;
        $email = addslashes($this->email);
        $attivo = intval($this->attivo); // il campo boolean in mysql è rappresentato come un intero 1 o 0
        $eliminato = intval($this->eliminato); // il campo boolean in mysql è rappresentato come un intero 1 o 0
        $data_eliminazione = $this->data_eliminazione;
        $telefono = addslashes($this->telefono);
        $volontario = intval($this->volontario);
        $amministratore = intval($this->amministratore);

        $query = "REPLACE INTO utenti(id_utente, username, password, data_creazione, ultimo_accesso, email, attivo, eliminato, data_eliminazione, telefono
		volontario, amministratore)
		VALUES ('$id_utente', '$username', '$password', '$data_creazione', '$ultimo_accesso', '$email', '$attivo', '$eliminato', '$data_eliminazione', '$telefono', '$volontario', $amministratore)";

        $comando = $dbconn->prepare($query);
        $esegui = $comando->execute();
        //rowCount()==1 ci dice il numero di righe che sono state coinvolte nell'operazione
        if ($esegui == true && $comando->rowCount() == 1) {
            return true;
        } else {
            return false;
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
        $query = "SELECT * FROM utenti WHERE id_utente='$id_utente";
        $comando = $dbconn->prepare($query);
        $esegui = $comando->execute();
        if ($esegui == true && $riga = $comando->fetch(PDO::FETCH_ASSOC)) {
            $this->id_utente = $riga['id_utente'];
            $this->username = $riga['username'];
            $this->password = $riga['password'];
            $this->data_creazione = $riga['data_creazione'];
            $this->ultimo_accesso = $riga['ultimo_accesso'];
            $this->email = $riga['email'];
            $this->attivo = $riga['attivo'];
            $this->eliminato = $riga['eliminato'];
            $this->data_eliminazione = $riga['data_eliminazione'];
            $this->telefono = $riga['telefono'];
            $this->volontario = $riga['volontario'];
            $this->amministratore = $riga['amministratore'];

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
     * @return bool esito dell'accesso
     */
    public static function login($username, $password)
    {
        global $dbconn;

        $username = addslashes($username);
        $password = hash('sha256', $password);

        $query = "SELECT * FROM utenti WHERE username='$username' AND password='$password'";
        $comando = $dbconn->prepare($query);
        $esegui = $comando->execute();

        if ($esegui == true && $riga = $comando->fetch(PDO::FETCH_ASSOC)) {
            $_SESSION['id_utente'] = $riga['id_utente'];
            $_SESSION['username'] = $riga['username'];
            return true;
        } else {
            Notifica::accoda("Dati di accesso non validi", Notifica::TIPO_ERRORE);
            return false;
        }
    }

    /**
     * Disconnette l'utente dal sito
     */
    public static function Logout()
    {
        session_destroy();
    }

    /**
     * Controlla se esiste l'ID Utente specificato
     * @author Gaia Barale
     * @param int $id_utente
     * @return bool vero o falso
     */
    public static function esisteId($id_utente)
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
    public static function esisteUsername($username)
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
     * @return Utente dati dell'utente collegato
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

        if (empty($this->id_utente)) {
            Notifica::accoda("Inserire identificativo utente", Notifica::TIPO_ERRORE);
            $valido = false;
        }

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
    public static function inviaMailRecuperoPassword($usernameOEmail)
    {
        $casuale = uniqid("", true);



        //INVIO DEL MESSAGGIO DI RECUPERO
        $mailer = new PHPMailer(true);
        //imposto indirizzo utente
        $mailer->addAddress('');
        $mailer->Subject = "[DONATEMPO] Recupero password";
        $mailer->ContentType = PHPMailer::CONTENT_TYPE_TEXT_HTML;
        //TODO: impostare il corpo del messaggio
        $mailer->Body = ""; //corpo del messaggio
        $invia = $mailer->send();
        if ($invia) {
            Notifica::accoda("Controlla la tua casella di posta. Ti abbiamo inviato le istruzioni per recuperare la password del tuo account", Notifica::TIPO_SUCCESSO);
        } else {
            Notifica::accoda("Errore nell'invio del messaggio", Notifica::TIPO_ERRORE);
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
}
