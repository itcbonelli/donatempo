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
                        <a class="dropdown-item" href="#">Esci</a>
                    </div>
                </li>
            </ul>
            
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <div class="col-4">             

                <ul class="nav flex-column menu-navigazione">

                    <?php
                    function voce_menu($nome, $id, $icona, $href='#') {
                        $active='';
                        if(isset($link_attivo) && $link_attivo==$id) {
                            $active=' active ';
                        }
                        $codice = "<li class='nav-item'>
                            <a class='nav-link {$active}' href='$href'><i class='$icona'></i> {$nome}</a>
                        </li>";

                        echo $codice;
                    }

                    voce_menu('Cruscotto', 'dashboard', 'fa fa-dashboard', '#');
                    voce_menu('Utenti e profili', 'utenti', 'fa fa-user', '#');
                    voce_menu('Associazioni e volontari', 'associazioni', 'fa fa-building', '#');
                    voce_menu('Servizi', 'servizi', 'fa fa-handshake-o', '#');
                    voce_menu('Stati avanzamento richiesta', 'stati_richiesta', 'fa fa-percent', '#');
                    voce_menu('Comuni, province e zone', 'zone', 'fa fa-map-marker', '#');
                    ?>
                   
                </ul>

            </div>
            <div class="col-8">
                <?php echo isset($contenuto) ? $contenuto : ''; ?>
            </div>
        </div>
    </div>

    <?php require_once(__DIR__ . '/footer.php'); ?>
</body>

</html>