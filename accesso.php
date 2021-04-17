<?php

use itcbonelli\donatempo\AiutoInput;
use itcbonelli\donatempo\Notifica;
use itcbonelli\donatempo\tabelle\Utente;

require_once __DIR__ . '/include/main.php';

if ($_POST) {
    $username = AiutoInput::leggiStringa('username');
    $password = AiutoInput::leggiStringa('password');

    if (!empty($username) && !empty($password)) {
        $login = Utente::login($username, $password);
        if ($login) {
            header('location:area-riservata.php');
        }
    }
}



?>
<?php ob_start(); ?>

<div class="container">
    <h1>Accesso</h1>

    <?php Notifica::MostraNotifiche(); ?>

    <form action="" method="post">
        <div class="form-group">
            <label for="username">Nome utente o e-mail</label>
            <input type="text" class="form-control" name="username" id="username" />
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" id="password" />
        </div>
        <button type="submit" class="btn btn-primary">Accedi</button>
    </form>
    <ul class="nav flex-column">
        <li class="nav-item"><a href="recupero-password.php" class="nav-link">Hai dimenticato i dati di accesso?</a></li>
        <li class="nav-item"><a href="registrazione.php" class="nav-link">Non hai ancora un account?</a></li>
    </ul>
</div>


<?php $contenuto = ob_get_clean(); ?>
<?php
require_once __DIR__ . '/template/index.php';
?>