<?php
if (!defined('PERCORSO_BASE')) {
    define('PERCORSO_BASE', '.');
}
?>
<!DOCTYPE html>
<html lang="it">

<head>
    <title><?php echo isset($titolo_pagina) ? $titolo_pagina : 'Gestione DONATEMPO'; ?></title>
    <?php require_once(__DIR__ . ' /head.php'); ?>
</head>

<body>

    <nav class="navbar navbar-expand-sm navbar-light bg-light">
        <a class="navbar-brand" href="#">DONATEMPO <span class="badge badge-warning">Gestione</span></a>
        <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse"
            aria-expanded="false" aria-label="Attiva navigazione">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">

            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{Utente}</a>
                    <div class="dropdown-menu" aria-labelledby="dropdownId" style="right:0; left:auto;">
                        <a class="dropdown-item" href="#">Il mio profilo</a>
                        <a class="dropdown-item" href="logout.php">Esci</a>
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
                    function voce_menu($nome, $id, $icona, $href='#') {
                        global $link_attivo;
                        $active='';
                        if(isset($link_attivo) && $link_attivo==$id) {
                            $active=' active ';
                        }
                        $codice = "<li class='nav-item'>
                            <a class='nav-link {$active}' href='$href'><i class='$icona'></i> {$nome}</a>
                        </li>";

                        echo $codice;
                    }

                    voce_menu('Cruscotto', 'dashboard', 'fa fa-dashboard', 'index.php');
                    voce_menu('Utenti', 'utenti', 'fa fa-user', 'utenti.php');
                    voce_menu('Profili', 'profili', 'fa fa-user', 'profili.php');
                    voce_menu('Associazioni', 'associazioni', 'fa fa-building', 'associazioni.php');
                    voce_menu('Esercenti', 'esercenti', 'fa fa-briefcase', 'esercenti.php');
                    voce_menu('Servizi', 'servizi', 'fa fa-handshake-o', 'servizi.php');
                    voce_menu('Stati avanzamento richiesta', 'stati-avanzamento', 'fa fa-percent', 'stati-avanzamento.php');
                    voce_menu('Comuni', 'comuni', 'fa fa-map-marker', 'comuni.php');
                    voce_menu('Province', 'province', 'fa fa-map-marker', 'province.php');
                    voce_menu('Zone', 'zone', 'fa fa-map-marker', 'zone.php');
                    ?>
                   
                </ul>

            </div>
            <div class="col-lg-9 col-md-8">
                <?php echo isset($contenuto) ? $contenuto : ''; ?>
            </div>
        </div>
    </div>

    <?php require_once(__DIR__ . '/footer.php'); ?>
</body>

</html>