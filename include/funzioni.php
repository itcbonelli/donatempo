<?php
require_once __DIR__ . '/connessione.php';

/**
 * Messaggio da comunicare all'utente
 */
class Messaggio
{
    public const TIPO_ERRORE = 'error';
    public const TIPO_SUCCESSO = 'success';
    public const TIPO_INFORMAZIONE = 'info';

    /**
     * Tipologia di messaggio. I valori ammessi sono rappresentati dalle costanti TIPO_ della presente classe
     */
    public string $tipo;

    /**
     * Testo del messaggio da mostrare all'utente
     */
    public string $testo;

    /**
     * Funzione costruttore
     */
    public function __construct(string $testo, string $tipo = self::TIPO_INFORMAZIONE)
    {
        $this->tipo = $tipo;
        $this->testo = $testo;
    }
}

/**
 * Coda dei messaggi generati dalle pagina
 * @var Messaggio[]
 */
$messaggi = [];

/**
 * Accoda un messaggio da mostrare all'utente
 */
function accoda_messaggio(string $messaggio, string $tipo = Messaggio::TIPO_INFORMAZIONE)
{
    global $messaggi;
    $messaggi[] = new Messaggio($messaggio, $tipo);
}

/**
 * Mostra i messaggi a video nel punto in cui viene richiamata la funzione
 */
function mostra_messaggi()
{
    global $messaggi;

    foreach ($messaggi as $messaggio) {
        printf("<div class='alert alert-%s>%s</div>", $messaggio->tipo, htmlentities($messaggio->testo));
    }
}
