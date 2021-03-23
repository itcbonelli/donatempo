<?php
require_once __DIR__ . '/include/main.php';
?>
<?php ob_start(); ?>

<div class="container">
    <h1>Recupero password</h1>

    <form action="" method="post">
        <div class="form-group">
            <label for="username">Nome utente o e-mail</label>
            <input type="text" class="form-control" name="username" id="username" />
        </div>
       
        <button type="submit" class="btn btn-primary">Accedi</button>
    </form>

</div>


<?php $contenuto = ob_get_clean(); ?>
<?php
require_once __DIR__ . '/template/index.php';
?>