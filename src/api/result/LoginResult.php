<?php

namespace itcbonelli\donatempo\api\result;

/**
 * Risultato login da fornire in output
 */
class LoginResult
{
    /**
     * Risultato login
     */
    public bool $result = false;

    /**
     * Token di sessione
     */
    public string $session_id = "";

    /**
     * Nome utente
     */
    public string $username = "";

    function __construct()
    {
        $this->sessionToken = session_id();
    }
}
