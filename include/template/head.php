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

<!-- Icone -->
<link rel="apple-touch-icon" sizes="57x57" href="<?php echo PERCORSO_BASE; ?>/icon/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="<?php echo PERCORSO_BASE; ?>/icon/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="<?php echo PERCORSO_BASE; ?>/icon/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="<?php echo PERCORSO_BASE; ?>/icon/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="<?php echo PERCORSO_BASE; ?>/icon/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="<?php echo PERCORSO_BASE; ?>/icon/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="<?php echo PERCORSO_BASE; ?>/icon/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="<?php echo PERCORSO_BASE; ?>/icon/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="<?php echo PERCORSO_BASE; ?>/icon/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="<?php echo PERCORSO_BASE; ?>/icon/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="<?php echo PERCORSO_BASE; ?>/icon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="<?php echo PERCORSO_BASE; ?>/icon/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo PERCORSO_BASE; ?>/icon/favicon-16x16.png">
<link rel="manifest" href="<?php echo PERCORSO_BASE; ?>/icon/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="<?php echo PERCORSO_BASE; ?>/icon/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">


<?php /* Bootstrap: framework CSS e JS per applicazioni responsive */ ?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
<?php /* Font Awesome: libreria di icone vettoriali */ ?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
<?php /* Foglio di stile personalizzato */ ?>
<link rel="stylesheet" href="<?php echo PERCORSO_BASE; ?>/css/style.css" />
