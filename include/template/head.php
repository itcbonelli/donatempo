<?php
/*
Questo file contiene le dichiarazioni e gli script che dovranno apparire nell'head di tutte le pagine.
*/

//alcuni file sono caricati con url relativo.
//ho bisogno di una costante che mi permetta di raggiungere il percorso base del sito.
//se tale costante non è definita, la definisco assumendo che il file si trovi nella web root.
if(!defined('PERCORSO_BASE')) {
    define('PERCORSO_BASE', '.');
}
?>

<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

<?php /* Bootstrap: framework CSS e JS per applicazioni responsive */ ?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
<?php /* Font Awesome: libreria di icone vettoriali */ ?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
<?php /* Foglio di stile personalizzato */ ?>
<link rel="stylesheet" href="<?php echo PERCORSO_BASE ?>/css/style.css" />