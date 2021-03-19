<?php

class MailMessage
{
    /**
     * Elenco destinatari
     */
    public $to = [];
    
    /**
     * 
     */
    public $cc = [];
    public $bcc = [];

    /**
     * Oggetto del messaggio
     */
    public $subject = "";

    /**
     * Contenuto
     */
    public $content = "";

    /**
     * Invia il messaggio
     */
    public function send()
    {
    }
}
