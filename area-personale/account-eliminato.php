<?php

require_once __DIR__ . '/../include/main.php';
define('PERCORSO_BASE', '../');

?>
<?php ob_start(); ?>


<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <p><i class="fa fa-user-times fa-4x" aria-hidden="true"></i></p>
                <h1>Account eliminato</h1>

                <p class="lead">La tua richiesta di eliminazione dell'account è stata eseguita correttamente.<br />Ci dispiace vederti andar via.</p>

                <p><a href="../index.php" class="btn btn-outline-primary">Torna alla home page</a></p>
            </div>
        </div>
    </div>
</div>
<?php $contenuto = ob_get_clean(); ?>

<?php
require_once __DIR__ . '/../template/index.php';
?>