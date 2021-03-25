<?php

namespace itcbonelli\donatempo\tabelle;

use Exception;
use itcbonelli\donatempo\AiutoConvalida;
use itcbonelli\donatempo\Notifica;

class Esercente
{
    public ?int $id_esercente;
    public ?string $nome;
    public ?string $ragsoc;
    public ?string $piva;
    public ?string $cod_comune;
    public ?string $indirizzo;
    public ?string $cap;
    public ?string $descrizione;
    public ?string $logo_url;
    public bool $attivo = true;

    public function carica($id_esercente): bool
    {
        throw new Exception("Non implementato");
    }

    public function salva(): bool
    {
        throw new Exception("Non implementato");
    }

    public function elimina(): bool
    {
        throw new Exception("Non implementato");
    }

    /**
     * @author Lucia Tosello
     */
    public function convalida(): bool
    {
        $ris=true;
    
        if (AiutoConvalida::LunghezzaTesto($this->nome, "Il nome dell'esercizio deve essere di lunghezza compresa tra 1 e 50", 1, 50)) {
            Notifica::accoda("Inserire nome", Notifica::TIPO_ERRORE);
            $ris=false;
        }

        return $ris;
    }
}
