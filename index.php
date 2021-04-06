<?php
//carico il file principale
require_once __DIR__ . '/include/main.php';

?>
<?php ob_start(); ?>

<div class="jumbotron">
  <div class="container">
    <h1 class="display-3">DONATEMPO</h1>
    <p class="lead">Aiutiamo le associazioni di volontariato e i loro partecipanti ad organizzare il loro tempo e ad incontrare chi ha bisogno di una mano. Scopri che cosa possiamo fare per te.</p>
    <p class="lead">
      <a class="btn btn-success btn-lg" href="registrazione.php" role="button"><i class="fa fa-pencil" aria-hidden="true"></i> Registrati ora</a>
      <a class="btn btn-info btn-lg" href="volontario/diventa-volontario.php" role="button"><i class="fa fa-hand-peace-o" aria-hidden="true"></i> Diventa volontario</a>
    </p>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-12">
      <h1>Benvenuti</h1>
      <p class="lead">Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis vitae sint optio doloribus iusto eaque dolor omnis quisquam dolores expedita! Nihil quis laudantium delectus dignissimos at, laboriosam recusandae modi facilis.</p>
    </div>
  </div>
</div>
<?php $contenuto = ob_get_clean(); ?>

<?php
require_once __DIR__ . '/template/index.php';
?>