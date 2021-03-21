<?php

/**
 * Messaggio di posta elettronica
 */
class MessaggioMail
{
    /**
     * Elenco destinatari
     */
    public $a = [];

    /**
     * 
     */
    public $cc = [];

    /**
     * Elenco destinatari in copia nascosta
     */
    public $ccn = [];

    /**
     * Oggetto del messaggio
     */
    public $oggetto = "";

    /**
     * Contenuto
     */
    public $contenuto = "";

    /**
     * Carica un template di messaggio e sostituisce i segnaposto dei valori
     */
    public function caricaTemplate(string $nome, array $valori)
    {
    }

    /**
     * Invia il messaggio
     */
    public function invia(): bool
    {
        throw new Exception("Da implementare");
    }
}
