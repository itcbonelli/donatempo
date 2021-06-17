<?php

namespace itcbonelli\donatempo;

use itcbonelli\donatempo\Notifica;
use RuntimeException;

/**
 * Fornisce funzioni di supporto per l'upload e la manipolazione di file
 */
class AiutoUpload
{

    /**
     * Sovrascrive il file con lo stesso nome
     */
    const AZIONE_SOVRASCRIVI = 'sovrascrivi';

    /**
     * Impedisce il caricamento del file se è presente un file con lo stesso nome
     */
    const AZIONE_BLOCCA = 'blocca';

    /**
     * Rinomina il file in modo da evitare conflitti se esiste un file con lo stesso nome
     */
    const AZIONE_RINOMINA = 'rinomina';

    /**
     * Filtro estensioni ammesse. Se lasciato vuoto ammette tutte le estensioni di file
     */
    public $estensioniAmmesse = [];

    /**
     * Filtro tipi MIME ammessi per il file caricato
     */
    public $tipiMimeAmmessi = [];

    /**
     * Genera un nome casuale per i file caricati.
     */
    public bool $generaNomeCasuale = false;


    /**
     * Determina come gestire l'upload di un file con lo stesso nome
     */
    public string $azioneSuStessoNome = self::AZIONE_RINOMINA;

    /**
     * Dimensione massima ammessa per i file
     */
    public int $maxDimensioneFile = 0;

    /**
     * Directory di destinazione del file caricato (relativa alla web root del sito)
     */
    public string $destinazione = UPLOAD_PATH;


    /**
     * Carica un file
     * @param string $nome nome del campo file
     * @param string $fname nome da assegnare al file caricato
     * @return string percorso relativo del file caricato
     */
    public function carica($nome, $fname = "")
    {
        //estraggo l'estensione del file
        $estensione = strtolower(pathinfo($_FILES[$nome]['name'], PATHINFO_EXTENSION));
        //estraggo il nome del file senza estensione
        $nomefile = strtolower(pathinfo($_FILES[$nome]['name'], PATHINFO_FILENAME));

        //se non è stato fornito un nome da attribuire al file
        if (strlen($fname)==0) {
            //se viene richiesto di generare un nome casuale
            if ($this->generaNomeCasuale) {
                //genero una stringa alfanumerica random
                $nomefile = uniqid('', true);
            } else {
                //altrimenti, ripulisco il nome originale del file da caratteri indesiderati
                $nomefile = self::sanitize($nomefile, true, false);
            }
        } else {
            $nomefile = $fname;
        }

        $target_file = sprintf("%s/%s.%s", $this->destinazione, $nomefile, $estensione);

        if (file_exists($target_file)) {
            if ($this->azioneSuStessoNome == self::AZIONE_BLOCCA) {
                throw new RuntimeException("Esiste già un file caricato con lo stesso nome");
            } elseif ($this->azioneSuStessoNome == self::AZIONE_RINOMINA) {
                $conta = 1;
                while (file_exists($target_file)) {
                    $target_file = (sprintf("%s/%s_%d.%s", $this->destinazione, $nomefile, $conta, $estensione));
                    $conta++;
                }
            }
        }

        // Controllo dimensione file
        if ($this->maxDimensioneFile > 0 && $_FILES[$nome]["size"] > $this->maxDimensioneFile) {
            throw new RuntimeException("La dimensione del file caricato eccede il massimo consentito");
        }

        if (!empty($this->estensioniAmmesse) && !in_array($estensione, $this->estensioniAmmesse)) {
            throw new RuntimeException("L'estensione del file caricato non è compresa tra quelle consentite");
        }

        move_uploaded_file($_FILES[$nome]["tmp_name"], $target_file);
        return $nomefile . '.' . $estensione;
    }

    /**
     * Restituisce una stringa ripulita dei caratteri speciali
     * @param string $string La stringa da ripulire.
     * @param boolean $force_lowercase Forza la conversione in minuscolo
     * @param boolean $strip_alphanum Se impostato a true elimina i caratteri non alfanumerici
     */
    public static function sanitize($string, $force_lowercase = true, $strip_alphanum = false)
    {
        //caratteri da rimuovere
        $strip = array(
            "~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "=", "+", "[", "{", "]",
            "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
            "â€”", "â€“", ",", "<", ".", ">", "/", "?"
        );
        
        $clean = trim(str_replace($strip, "", strip_tags($string)));
        $clean = preg_replace('/\s+/', "-", $clean);
        $clean = ($strip_alphanum) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean;
        return ($force_lowercase) ? ((function_exists('mb_strtolower')) ? mb_strtolower($clean, 'UTF-8') : strtolower($clean)) : $clean;
    }
}
