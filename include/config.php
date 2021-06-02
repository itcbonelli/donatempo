<?php
/**
 * Attiva la modalità di debug, nella quale i messaggi di errore sono mostrati a video.
 */
define('DEBUG', true);

/**
 * Host MySQL
 */
define('DB_HOST', '127.0.0.1');

/**
 * Porta MySQL
 */
define('DB_PORT', 3306);

/**
 * Nome utente del database
 */
define('DB_USER', 'root');

/**
 * Password del database
 */
define('DB_PASSWORD', '');

/**
 * Nome del database
 */
define('DB_NAME', 'donatempo');

/**
 * Charset utilizzato dalla connessione
 */
define('DB_CHARSET', 'utf8');

/**
 * Lingua e cultura dell'applicazione
 */
define('LOCALE', 'it-IT');

/**
 * Fuso orario adottato
 */
define('TIMEZONE', 'Europe/Rome');

/**
 * Percorso assoluto dei file caricati
 */
define('UPLOAD_PATH', realpath(__DIR__ . '/../uploads'));

/**
 * Percorso relativo dei file caricati
 */
define('UPLOAD_PATH_REL', realpath('uploads/'));