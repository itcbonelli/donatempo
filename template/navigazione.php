<nav class="navbar navbar-expand-sm navbar-light">
    <a class="navbar-brand" href="<?php echo PERCORSO_BASE ?>/index.php">
        <img src="<?php echo PERCORSO_BASE; ?>/img/logo-donatempo-48px.png" alt="Donatempo">
        DONATEMPO
    </a>
    <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Attiva o disattiva navigazione">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavId">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item active">
                <a class="nav-link" href="<?php echo PERCORSO_BASE ?>/index.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="ricerca-servizi.php">Servizi</a>
            </li>

        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-hand-peace-o" aria-hidden="true"></i>
                    Area volontario</a>
                <div class="dropdown-menu" aria-labelledby="dropdownId">
                    <a class="dropdown-item" href="#"><i class="fa fa-user-circle" aria-hidden="true"></i> Profilo</a>
                    <a class="dropdown-item" href="#"><i class="fa fa-ticket" aria-hidden="true"></i> Richieste</a>
                    <a class="dropdown-item" href="#"><i class="fa fa-calendar-check-o" aria-hidden="true"></i> Mie disponibilità</a>
                </div>
            </li>
            <li class="nav-item">
                <a href="accesso.php" class="nav-link"><i class="fa fa-user-circle-o" aria-hidden="true"></i> Accedi</a>
            </li>
            <li class="nav-item">
                <a href="registrazione.php" class="nav-link"><i class="fa fa-user-plus" aria-hidden="true"></i> Registrati</a>
            </li>
        </ul>
    </div>
</nav>