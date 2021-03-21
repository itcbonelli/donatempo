<?php 
//carico il file principale
require_once __DIR__ . '/include/main.php';

?>
<?php ob_start(); ?>

    <div class="jumbotron">
      <h1 class="display-3">DONATEMPO</h1>
      <p class="lead">L'app che ti aiuta a trovare chi può darti una mano</p>
      <hr class="my-2">
      <p>More info</p>
      <p class="lead">
        <a class="btn btn-primary btn-lg" href="Jumbo action link" role="button">Jumbo action name</a>
      </p>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Registrazione</h1>

                <form action="">
                    
                </form>
            </div>
        </div>
    </div>
<?php $contenuto = ob_get_clean(); ?>

<?php
require_once __DIR__ . '/template/index.php';
?>