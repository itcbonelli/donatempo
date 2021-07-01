<?php

namespace itcbonelli\donatempo;

use DateTime;
use DateTimeZone;
use Exception;

/**
 * Funzioni per la conversione di date
 */
class AiutoData
{

    const FORMATOVIS1 = 'd/m/Y H:i:s';
    const FORMATOVIS2 = 'd/m/Y';

    /**
     * Ottiene un oggetto data con data e ora correnti e fuso orario
     * @return DateTime
     */
    public static function adesso()
    {
        return new DateTime('now', new DateTimeZone(TIMEZONE));
    }

    /**
     * Converte una stringa restituita dal database in un oggetto data PHP
     * @param string $valore valore da convertire
     * @return DateTime 
     */
    public static function daStringaDB(string $valore, string $formato = 'Y-m-d H:i:s')
    {
        return DateTime::createFromFormat($formato, $valore);
    }



    /**
     * Crea un oggetto data a partire da un valore temporale
     * @param int $valore timestamp da convertire
     */
    public static function daTimeStamp(int $valore)
    {
        return new DateTime($valore, new DateTimeZone(TIMEZONE));
    }

    /**
     * Formatta una data in una stringa leggibile con la data nel formato italiano
     */
    public static function formatta(mixed $valore, $includiOrario = true)
    {
        $formato = $includiOrario ? self::FORMATOVIS1 : self::FORMATOVIS2;
        if (gettype($valore) == 'object' && $valore instanceof DateTime) {
            return date_format($valore, $formato);
        } elseif (gettype($valore) == 'int') {
            $timestamp = $valore;
            return date_format(new DateTime($timestamp, new DateTimeZone(TIMEZONE)), $formato);
        } else {
            throw new Exception('Tipo di valore temporale non valido');
        }
    }
}
