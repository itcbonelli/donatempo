<?php

namespace itcbonelli\donatempo;

use itcbonelli\donatempo\AiutoInput;
use itcbonelli\donatempo\tabelle\ApiKey;
use itcbonelli\donatempo\tabelle\Utente;

/**
 * Fornisce funzioni di supporto per le API
 */
class AiutoApi
{

    //CODICI DI STATO HTTP
    //Il protocollo http prevede diversi codici di stato che servono a comunicare al client
    //il risultato del comando appena inviato

    //Richiesta valida
    const STATO_HTTP_OK = 200;
    //richiesta valida e contenuto creato
    const STATO_HTTP_CREATO = 201;
    //richiesta valida e contenuto modificato
    const STATO_HTTP_MODIFICATO = 202;
    //richiesta formulata in maniera non corretta (esempio: parametri errati o mancanti)
    const STATO_HTTP_RICHIESTA_ERRATA = 400;
    //utente non autorizzato ad accedere alla risorsa richiesta.
    const STATO_HTTP_NON_AUTORIZZATO = 403;
    //contenuto non trovato
    const STATO_HTTP_NON_TROVATO = 404;
    //errore verificatosi all'interno dell'applicazione a causa di un malfunzionamento della stessa.
    const STATO_HTTP_ERRORE_SERVER = 500;


    /**
     * Autentica l'utente nel sistema attraverso le apposite intestazioni HTTP.
     * Se la richiesta viene aperta nel browser sarà mostrata una maschera di log-in 
     * e la sessione sarà mantenuta fino alla chiusura dell'applicazione.
     * 
     * @return Utente
     */
    public static function autentica()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header('WWW-Authenticate: Basic realm="Donatempo API"');
            header('HTTP/1.0 401 Unauthorized');
            self::inviaJSON([
                'risultato' => false,
                'errore' => 'Accesso non autorizzato'
            ], 401);
            exit;
        } else {
            $username = $_SERVER['PHP_AUTH_USER'];
            $password = $_SERVER['PHP_AUTH_PW'];
            $utente = Utente::login($username, $password);
            return $utente;
        }
    }


    public static function controllaChiave() {
        $chiave=AiutoInput::leggiStringa('apikey', '', 'GPC');
        if(ApiKey::controlla($chiave)) {
            return true;
        } else {
            self::inviaJSON(['risultato' => false, 'errore' => ''], 400);
        }
    }


    /**
     * Controllo di sicurezza
     * Richiede al client di inviare un parametro _ts con il timestamp corrente.
     * 
     * Questo controllo può essere utilizzato per contrastare alcuni attacchi di tipo DoS.
     * Funziona solo se l'orologio di sistema del client e del server sono allineati, con uno scarto temporale minimo.
     * 
     * @param int $scarto scarto temporale ammesso. Default 900 secondi (15 minuti)
     */
    public static function controllaTempo(int $scarto = 900)
    {
        $t = AiutoInput::leggiIntero('_ts', 0, 'GP');
        $diff = abs(time() - $t);

        if ($diff > $scarto) {
            self::inviaJSON(['error' => 'Mancata corrispondenza tra la data e ora segnalata dal client e la data e ora del server'], 400);
        }
    }

    /**
     * Invia una risposta codificata in formato JSON
     * 
     * JSON (JavaScript Object Notation) è un metalinguaggio che permette di rappresentare 
     * come testo strutture dati quali array (anche a n dimensioni).
     * 
     * @param mixed $dati dati da inviare in output
     * @param int $codice codice di stato HTTP per la risposta
     */
    public static function inviaJSON($dati, int $codice = self::STATO_HTTP_OK)
    {
        //invio il codice di stato http
        http_response_code($codice);

        //imposto il contet-type della risposta come json
        header('Content-type: text/json');

        //codifico il dataset in formato json.
        //se sono in modalità di debug imposto il flag JSON_PRETTY_PRINT, 
        //che migliora la leggibilità dell'output (ma è leggermente più lento)
        echo json_encode($dati, DEBUG ? JSON_PRETTY_PRINT : 0);

        //con exit termino l'esecuzione di php. Ciò per evitare che l'output possa risultare 'inquinato'
        //da eventuale codice che si trova dopo il richiamo di questa funzione.
        //viene da sé che eventuali istruzioni di finalizzazione e chiusura di risorse devono essere
        //invocate prima di richiamare inviaJSON.
        exit;
    }
}
