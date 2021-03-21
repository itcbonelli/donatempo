<?php

use itcbonelli\donatempo\Notifica;

/**
 * Fornisce funzionalità per la convalida dei dati in input
 */
class AiutoConvalida
{
    /**
     * Verifica che la lunghezza del testo sia compresa nei limiti specificati
     * @param string $testo testo da convalidare
     * @param string $messaggio messaggio di errore mostrato in caso di mancata convalida
     * @param int $min lunghezza minima. Se omessa o <=0 la stringa può essere anche vuota
     * @param int $max lunghezza massima. Se omessa o <=0 la stringa potrà essere di qualsiasi lunghezza
     * @return bool esito convalida
     */
    public static function LunghezzaTesto(string $testo,  string $messaggio = "", int $min = 0, int $max = 0): bool
    {

        //se abbiamo un limite minimo di lunghezza
        if ($min > 0) {
            //primo controllo: che il testo non sia vuoto o null
            if (empty($testo)) {
                Notifica::accoda($messaggio, Notifica::TIPO_ERRORE);
                return false;
            }

            //secondo controllo: che la lunghezza del testo non sia inferiore al minimo
            if (strlen($testo) < $min) {
                Notifica::accoda($messaggio, Notifica::TIPO_ERRORE);
                return false;
            }
        }

        //se arriviamo qua vuol dire che non c'era un limite minimo, oppure il testo ha superato il controllo
        //ora verifichiamo che non sia superiore al massimo
        if ($max > 0) {
            
        }

        return true;
    }

    /**
     * Determina se il testo fornito in input è un indirizzo e-mail valido
     * @return bool True se valido, false in caso contrario
     */
    public static function Email($indirizzo, $messaggio="Indirizzo e-mail non valido") {
        if (!filter_var($indirizzo, FILTER_VALIDATE_EMAIL)) {
            Notifica::accoda($messaggio, Notifica::TIPO_ERRORE);
        }
    }
}
