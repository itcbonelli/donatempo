<?php

namespace itcbonelli\donatempo;

/**
 * Fornisce metodi per la convalida e la sanificazione dei dati in input
 */
class AiutoInput
{

    /**
     * Legge un valore in input e lo restituisce, oppure restituisce un valore predefinito
     * @param $nome
     */
    public static function leggi(string $nome, mixed $default = null, string $ordine = 'GPC')
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
                    break;
            }
        }
        return $valore;
    }

    public static function leggiStringa(string $nome, ?string $default = '', string $ordine = 'GPC')
    {
        return strval(self::leggi($nome, $default, $ordine));
    }

    public static function leggiIntero(string $nome, int $default = null, string $ordine = 'GPC')
    {
        return intval(self::leggi($nome, $default, $ordine));
    }

    public static function leggiFloat(string $nome, float $default = null, string $ordine = 'GPC')
    {
        return floatval(self::leggi($nome, $default, $ordine));
    }

    public static function leggiBool(string $nome, bool $default = null, string $ordine = 'GPC')
    {
        return boolval(self::leggi($nome, $default, $ordine));
    }
}
