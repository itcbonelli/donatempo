<?php

use itcbonelli\donatempo\AiutoInput;
use itcbonelli\donatempo\tabelle\Utente;


/**
 * Verifica l'accesso dell'utente al sistema
 * 
 * Dati in input \
 * [POST] username \
 * [POST] password \
 * Risultato \
 * [
 *      result => true se l'utente è stato correttamente autenticato ed è attivo
 * ]
 */
function login()
{
    $username = AiutoInput::leggiStringa('username', '', 'P');
    $password = AiutoInput::leggiStringa('password', '', 'P');

    $login=Utente::login($username, $password);

    $risposta=[
        'result' => false,
        'username' => '',
    ];

    if($login) {
        $risposta['result'] = true;
        $risposta['username'] = $username;
    } else {
        http_response_code(403);
    }

    header('Content-type: text/json');
    echo json_encode($risposta);
}


function registrazione() {

}