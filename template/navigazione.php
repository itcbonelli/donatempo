<?php

use itcbonelli\donatempo\tabelle\Utente;

$utente = Utente::getMioUtente();
?>
<nav class="navbar navbar-expand-sm navbar-light sticky-top">
    <a class="navbar-brand" href="<?php echo PERCORSO_BASE ?>/index.php">
        <img src="<?php echo PERCORSO_BASE; ?>/img/logo-donatempo-48px.png" alt="Donatempo" style="height: 24px; vertical-align:middle;" />
        DONATEMPO
    </a>
    <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Attiva o disattiva navigazione">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavId">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="<?php echo PERCORSO_BASE ?>/index.php"><i class="fa fa-home" aria-hidden="true"></i> Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo PERCORSO_BASE ?>/ricerca-servizi.php"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Servizi</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?php echo PERCORSO_BASE ?>/gestione/index.php" target="_blank"><i class="fa fa-wrench" aria-hidden="true"></i> Gestione</a>
            </li>

        </ul>
        <ul class="navbar-nav ml-auto">
            <?php if ($utente instanceof Utente) : ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-user-circle" aria-hidden="true"></i>
                        <?= $utente->username; ?></a>
                    <div class="dropdown-menu  dropdown-menu-right" aria-labelledby="dropdownId">

                        <?php if ($utente->volontario) : ?>
                            <a class="dropdown-item" href="<?php echo PERCORSO_BASE ?>/volontario/riconoscimenti.php"><i class="fa fa-trophy" aria-hidden="true"></i> Riconoscimenti</a>
                            <a class="dropdown-item" href="<?php echo PERCORSO_BASE ?>/volontario/mio-profilo.php"><i class="fa fa-user-circle" aria-hidden="true"></i> Profilo</a>
                            <a class="dropdown-item" href="<?php echo PERCORSO_BASE ?>/volontario/mie-richieste.php"><i class="fa fa-ticket" aria-hidden="true"></i> Richieste</a>
                            <a class="dropdown-item" href="<?php echo PERCORSO_BASE ?>/volontario/mie-disponibilita.php"><i class="fa fa-calendar-check-o" aria-hidden="true"></i> Mie disponibilità</a>
                        <?php else : ?>
                            <a class="dropdown-item" href="<?php echo PERCORSO_BASE ?>/rimborsi.php"><i class="fa fa-user-circle" aria-hidden="true"></i> Profilo</a>
                            <a class="dropdown-item" href="<?php echo PERCORSO_BASE ?>/volontario/mio-profilo.php"><i class="fa fa-user-circle" aria-hidden="true"></i> Profilo</a>
                            <a class="dropdown-item" href="<?php echo PERCORSO_BASE ?>/volontario/mie-richieste.php"><i class="fa fa-ticket" aria-hidden="true"></i> Richieste</a>
                        <?php endif; ?>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-danger" href="<?php echo PERCORSO_BASE ?>/logout.php"><i class="fa fa-times" aria-hidden="true"></i> Disconnetti</a>

                    </div>
                </li>
            <?php endif; ?>

            <?php if ($utente == null) : ?>
                <li class="nav-item">
                    <a href="<?php echo PERCORSO_BASE ?>/accesso.php" class="nav-link"><i class="fa fa-user-circle-o" aria-hidden="true"></i> Accedi</a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo PERCORSO_BASE ?>/registrazione.php" class="nav-link"><i class="fa fa-user-plus" aria-hidden="true"></i> Registrati</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>