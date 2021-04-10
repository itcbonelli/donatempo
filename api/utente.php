<?php

use itcbonelli\donatempo\AiutoConvalida;
use itcbonelli\donatempo\AiutoInput;
use itcbonelli\donatempo\tabelle\Utente;

/**
 * 
 */
function login()
{
    $username = AiutoInput::leggiStringa('username', '', 'P');
    $password = AiutoInput::leggiStringa('password', '', 'P');

    $login=Utente::login($username, $password);
    if($login) {
        
    }
}
