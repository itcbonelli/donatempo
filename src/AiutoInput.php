<?php

namespace itcbonelli\donatempo;

use DateTime;
use DateTimeZone;

/**
 * Fornisce metodi per semplificare la lettura, convalida e la sanificazione dei dati in input
 * @author Federico Flecchia <federico.flecchia@itcbonelli.edu.it>
 */
class AiutoInput
{

    /**
     * Legge un valore in input e lo restituisce, oppure restituisce un valore predefinito
     * @param string $nome
     * @param mixed $default valore predefinito
     * @param string $ordine ordine di lettura dei dati. 
     *                  G=GET, P=POST, C=COOKIE, S=SESSION.
     *                  Il valore è una stringa che contiene la composizione dei flag.
     * @return mixed il valore letto, oppure il valore di default.
     */
    public static function leggi(string $nome, $default = null, string $ordine = 'GPC')
    {
        $ordine = strtoupper($ordine);
        $valore = $default;
        for ($i = 0; $i < strlen($ordine); $i++) {
            switch ($ordine[$i]) {
                case 'G':
                    if (isset($_GET[$nome])) {
                        $valore = $_GET[$nome];
                    }
                    break;
                case 'P':
                    if (isset($_POST[$nome])) {
                        $valore = $_POST[$nome];
                    }
                    break;
                case 'C':
                    if (isset($_COOKIE[$nome])) {
                        $valore = $_COOKIE[$nome];
                    }
                case 'S':
                    if(isset($_SESSION[$nome])) {
                        $valore = $_SESSION[$nome];
                    }
                    break;
            }
        }
        return $valore;
    }

    /**
     * Legge un valore in input e lo restituisce, oppure restituisce un valore predefinito
     * @param string $nome
     * @param mixed $default valore predefinito
     * @param string $ordine ordine di lettura dei dati. 
     *                  G=GET, P=POST, C=COOKIE.
     *                  Il valore è una stringa che contiene la composizione dei flag.
     * @return mixed il valore letto, oppure il valore di default.
     */
    public static function leggiStringa(string $nome, string $default = '', string $ordine = 'GPC')
    {
        return strval(self::leggi($nome, $default, $ordine));
    }

    /**
     * Legge un valore in input e lo restituisce, oppure restituisce un valore predefinito
     * @param string $nome
     * @param mixed $default valore predefinito
     * @param string $ordine ordine di lettura dei dati. 
     *                  G=GET, P=POST, C=COOKIE.
     *                  Il valore è una stringa che contiene la composizione dei flag.
     * @return mixed il valore letto, oppure il valore di default.
     */
    public static function leggiIntero(string $nome, int $default = null, string $ordine = 'GPC')
    {
        return intval(self::leggi($nome, $default, $ordine));
    }

    /**
     * Legge un valore in input e lo restituisce, oppure restituisce un valore predefinito
     * @param string $nome
     * @param mixed $default valore predefinito
     * @param string $ordine ordine di lettura dei dati. 
     *                  G=GET, P=POST, C=COOKIE.
     *                  Il valore è una stringa che contiene la composizione dei flag.
     * @return mixed il valore letto, oppure il valore di default.
     */
    public static function leggiFloat(string $nome, float $default = null, string $ordine = 'GPC')
    {
        return floatval(self::leggi($nome, $default, $ordine));
    }

    /**
     * Legge un valore in input e lo restituisce, oppure restituisce un valore predefinito
     * @param string $nome
     * @param mixed $default valore predefinito
     * @param string $ordine ordine di lettura dei dati. 
     *                  G=GET, P=POST, C=COOKIE.
     *                  Il valore è una stringa che contiene la composizione dei flag.
     * @return mixed il valore letto, oppure il valore di default.
     */
    public static function leggiBool(string $nome, bool $default = null, string $ordine = 'GPC')
    {
        return boolval(self::leggi($nome, $default, $ordine));
    }

    /**
     * Legge un valore di tipo data
     * @param string $nome nome della variabile da leggere
     * @param mixed $default valore predefinito
     * @param string $ordine ordine di lettura dei dati.
     * @return DateTime istanza di DateTiem
     */
    public static function leggiData(string $nome, $default = null, string $ordine = 'GPC'): ?DateTime
    {
        $s = self::leggi($nome, $default, $ordine);
        if (!empty($s) && is_string($s)) {
            $d = DateTime::createFromFormat('Y-m-d', $s, new DateTimeZone(TIMEZONE));
        } else {
            $d = $default;
        }

        return $d;
    }

    /**
     * Legge un valore di tipo orario (stringa in formato h:i:s)
     */
    public static function leggiOrario(string $nome, $default = null, string $ordine = 'GPC'): ?DateTime
    {
        $s = self::leggi($nome, $default, $ordine);
        
        $d = DateTime::createFromFormat('H:i', $s, new DateTimeZone(TIMEZONE));
        if($d instanceof DateTime) {
            return $d;
        } else {
            return null;
        }
        
    }

    /**
     * Legge un valore di tipo data e ora in formato aaaa-mm-gg hh:mm:ss
     */
    public static function leggiOra(string $nome, $default = null, string $ordine = 'GPC'): ?DateTime
    {
        $s = self::leggi($nome, $default, $ordine);
        $d = DateTime::createFromFormat('Y-m-d h:i:s', $s, new DateTimeZone(TIMEZONE));
        return $d;
    }
}
