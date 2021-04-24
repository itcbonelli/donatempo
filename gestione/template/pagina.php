<?php

use itcbonelli\donatempo\tabelle\Utente;

if (!defined('PERCORSO_BASE')) {
    define('PERCORSO_BASE', '.');
}

$mio_utente=Utente::getMioUtente();
if(is_null($mio_utente)) {
    header('location:login.php');
}
?>
<!DOCTYPE html>
<html lang="it">

<head>
    <title><?php echo isset($titolo_pagina) ? $titolo_pagina : 'Gestione DONATEMPO'; ?></title>
    <meta charset="utf-8" />

    <!-- Icone -->
    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo PERCORSO_BASE; ?>/../icon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo PERCORSO_BASE; ?>/../icon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo PERCORSO_BASE; ?>/../icon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo PERCORSO_BASE; ?>/../icon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo PERCORSO_BASE; ?>/../icon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo PERCORSO_BASE; ?>/../icon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo PERCORSO_BASE; ?>/../icon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo PERCORSO_BASE; ?>/../icon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo PERCORSO_BASE; ?>/../icon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="<?php echo PERCORSO_BASE; ?>/../icon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo PERCORSO_BASE; ?>/../icon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo PERCORSO_BASE; ?>/../icon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo PERCORSO_BASE; ?>/../icon/favicon-16x16.png">
    <link rel="manifest" href="<?php echo PERCORSO_BASE; ?>/../icon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?php echo PERCORSO_BASE; ?>/../icon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="css/style.css" />
</head>

<body>

    <nav class="navbar navbar-expand-sm navbar-light bg-light">
        <a class="navbar-brand" href="#">DONATEMPO <span class="badge badge-warning">Gestione</span></a>
        <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Attiva navigazione">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">

            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropDown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                    <?= Utente::getMioUtente()->username; ?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropDown">
                        <a class="dropdown-item" href="../index.php"><i class="fa fa-home" aria-hidden="true"></i> Torna al sito</a>
                        <a class="dropdown-item text-danger" href="logout.php"><i class="fa fa-times" aria-hidden="true"></i> Esci</a>
                    </div>
                </li>
            </ul>

        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-md-4">

                <ul class="nav nav-pills flex-column menu-navigazione">

                    <?php
                    function voce_menu($nome, $id, $icona, $href = '#')
                    {
                        global $link_attivo;
                        $active = '';
                        if (isset($link_attivo) && $link_attivo == $id) {
                            $active = ' active ';
                        }
                        $codice = "<li class='nav-item'>
                            <a class='nav-link {$active}' href='$href'><i class='$icona'></i> {$nome}</a>
                        </li>";

                        echo $codice;
                    }

                    voce_menu('Cruscotto', 'dashboard', 'fa fa-dashboard', 'index.php');
                    voce_menu('Utenti', 'utenti', 'fa fa-user', 'utenti.php');
                    voce_menu('Profili', 'profili', 'fa fa-user', 'profili.php');
                    voce_menu('Badge', 'badge', 'fa fa-trophy', 'badge.php');
                    voce_menu('Associazioni', 'associazioni', 'fa fa-building', 'associazioni.php');
                    voce_menu('Esercenti', 'esercenti', 'fa fa-briefcase', 'esercenti.php');
                    voce_menu('Servizi', 'servizi', 'fa fa-handshake-o', 'servizi.php');
                    voce_menu('Richieste di aiuto', 'richieste', 'fa fa-question-circle', 'richieste.php');
                    voce_menu('Stati avanzamento richiesta', 'stati-avanzamento', 'fa fa-percent', 'stati-avanzamento.php');
                    voce_menu('Comuni', 'comuni', 'fa fa-map-marker', 'comuni.php');
                    voce_menu('Province', 'province', 'fa fa-map-marker', 'province.php');
                    voce_menu('Zone', 'zone', 'fa fa-map-marker', 'zone.php');
                    voce_menu('Informazioni sistema', 'pinfo', 'fa fa-info-circle', 'pinfo.php');
                    ?>

                </ul>

            </div>
            <div class="col-lg-9 col-md-8">
                <?php echo isset($contenuto) ? $contenuto : ''; ?>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>