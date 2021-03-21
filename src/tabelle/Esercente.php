<?php

namespace itcbonelli\donatempo\tabelle;

use Exception;

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
    public ?bool $attivo = true;

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

    public function convalida(): bool {
        throw new Exception("Non implementato");
    }
}
