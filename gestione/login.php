<?php

use itcbonelli\donatempo\AiutoInput;
use itcbonelli\donatempo\Notifica;
use itcbonelli\donatempo\tabelle\Utente;

require __DIR__ . '/../include/main.php';

if ($_POST) {
    $ut = AiutoInput::leggiStringa('username', '', 'P');
    $pwd = AiutoInput::leggiStringa('password', '', 'P');

    if (!empty($ut) && !empty($pwd)) {
        $login = Utente::login($ut, $pwd);
        if ($login) {
            header('location:index.php');
        } else {

        }
    }
}
?>
<!doctype html>
<html lang="it">

<head>
    <title>Accesso area di gestione Donatempo</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="css/login.css" />
</head>

<body>

    <div class="box-login">
        <?php Notifica::mostra_notifiche(); ?>
        <form action="" method="POST">
            <div class="form-group">
                <label for="username">Nome utente</label>
                <input type="text" name="username" id="username" class="form-control form-control-sm" required />
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control form-control-sm" required />
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-sm">Accedi</button>
            </div>
        </form>
    </div>


    <div class="credits">
        Photo by <a href="https://unsplash.com/@tomzzlee?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText">Tom Parsons</a> on <a href="/s/photos/giving?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText">Unsplash</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>