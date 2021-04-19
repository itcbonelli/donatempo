<?php

namespace itcbonelli\donatempo;

use itcbonelli\donatempo\AiutoInput;
use itcbonelli\donatempo\tabelle\Utente;

/**
 * Fornisce funzioni di supporto per le API
 */
class AiutoApi
{

    const STATO_HTTP_OK = 200;
    const STATO_HTTP_CREATO = 201;
    const STATO_HTTP_MODIFICATO = 202;
    const STATO_HTTP_RICHIESTA_ERRATA = 400;
    const STATO_HTTP_NON_AUTORIZZATO = 403;
    const STATO_HTTP_NON_TROVATO = 404;
    const STATO_HTTP_ERRORE_SERVER = 500;


    /**
     * Autentica l'utente nel sistema attraverso le apposite intestazioni HTTP.
     * 
     * @return Utente
     */
    public function autentica()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header('WWW-Authenticate: Basic realm="My Realm"');
            header('HTTP/1.0 401 Unauthorized');
            echo 'Accesso negato';
            exit;
        } else {
            $username = $_SERVER['HTTP_AUTH_USER'];
            $password = $_SERVER['HTTP_AUTH_PW'];
        }
    }


    /**
     * Controllo di sicurezza
     * Richiede al client di inviare un parametro _ts con il timestamp corrente.
     * 
     * Questo controllo può essere utilizzato per contrastare alcuni attacchi di tipo DoS.
     */
    public function controllaTempo()
    {
        $t = AiutoInput::leggiIntero('_ts', 0, 'GP');
        $diff = abs(time() - $t);

        if ($diff > 900) {
            self::inviaJSON(['error' => 'Mancata corrispondenza tra la data e ora segnalata dal client e la data e ora del server'], 400);
        }
    }

    /**
     * Invia una risposta codificata in formato JSON
     * @param mixed $dati dati da inviare in output
     * @param int $codice codice di stato HTTP per la risposta
     */
    public static function inviaJSON($dati, int $codice = self::STATO_HTTP_OK)
    {
        http_response_code($codice);
        header('Content-type: text/json');
        echo json_encode($dati, JSON_PRETTY_PRINT);
        exit;
    }
}
