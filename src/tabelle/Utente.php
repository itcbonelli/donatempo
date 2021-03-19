<?php

namespace itcbonelli\donatempo\tabelle;
use itcbonelli\donatempo\Notifica;
use \PDO, \DateTime, \Exception;

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
        $attivo = intval($this->attivo);
        $eliminato = $this->eliminato;
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
     * @param int $id_utente identificativo utente
     * @return bool esito operazione
     */
    public function carica($id_utente)
    {
        global $dbconn;
		$query = "SELECT * FROM utenti WHERE id_utente='$id_utente";
		$comando = $dbconn->prepare($query);
		$esegui=$comando->execute();
		if($esegui==true && $riga=$comando->fetch(PDO::FETCH_ASSOC)) {
			$this->id_utente=$riga['id_utente'];
			$this->username=$riga['username'];
			$this->password=$riga['password'];
            $this->data_creazione=$riga['data_creazione'];
            $this->ultimo_accesso=$riga['ultimo_accesso'];
            $this->email=$riga['email'];
			$this->attivo=$riga['attivo'];
			$this->eliminato=$riga['eliminato'];
			$this->data_eliminazione=$riga['data_eliminazione'];
			$this->telefono=$riga['telefono'];
			$this->volontario=$riga['volontario'];
			$this->amministratore=$riga['amministratore'];

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
            return false;
        }
    }

    /**
     * Controlla se esiste l'ID Utente specificato
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
     * @param int $username
     * @return bool vero o falso
     */
    public static function esisteUsername($username)
    {
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
     * 
     */
    public function convalida()
    {
        $errori = [];

        if (empty($this->id_utente)) {
            $errori[] = "Inserire identificativo utente";
        }
        if (empty($this->username)) {
            $errori[] = "Inserire l'username";
        }
        if (strlen($this->password)) {
            $errori[] = "Inserire la password";
        }
        if (empty($this->email)) {
            $errori[] = "Inserire l'email";
        }
        if (empty($this->telefono)) {
            $errori[] = "Inserire il telefono";
        }

        return $errori;
    }


    /**
     * Letti in input nome utente o e-mail di un utente, genera un nuovo codice alfanumerico di recupero password
     * e glielo invia per posta elettronica.
     * @param string $usernameOEmail nome utente o e-mail
     * @return bool esito operazione invio
     */
    public static function inviaMailRecuperoPassword($usernameOEmail) {
        $casuale = uniqid("", true);
    }

    /**
     * Reimposta la password del record utente corrente.
     * Modifica la proprietà password con l'hash calcolato della nuova password
     * @param string $nuovaPassword
     * @return bool esito operazione.
     */
    public function reimpostaPassword($nuovaPassword) {

    }


    /**
     * Ottiene il profilo dell'utente
     * @author Federico Flecchia
     * @return Profilo
     */
    public function getProfilo() {
        if($this->id==null) {
            return null;
        }
        $pro=new Profilo();
        $pro->carica($this->id_utente);
        return $pro;
    }
}