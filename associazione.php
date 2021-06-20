<?php
//carico il file principale

use itcbonelli\donatempo\AiutoInput;
use itcbonelli\donatempo\tabelle\Associazione;

require_once __DIR__ . '/include/main.php';

$id = AiutoInput::leggiIntero('id', -1, 'G');
if($id==-1) {
    throw new RuntimeException("Identificativo associazione non valido");
}
$associazione = new Associazione();
$associazione->carica($id);

?>
<?php ob_start(); ?>

<div class="container my-4">
    <div class="row">

        <div class="col-4">
            
            <img src="uploads/loghi-associazioni/<?= $associazione->url_logo ?>" alt="Logo associazione" class="img-fluid" />
            <h1><?= $associazione->ragsoc ?></h1>
        </div>
        <div class="col-8">
            <h4>Descrizione</h4>
            <?= htmlentities($associazione->descrizione); ?>

            <h4>Servizi offerti</h4>
            
        </div>
    </div>
</div>
<?php $contenuto = ob_get_clean(); ?>

<?php
require_once __DIR__ . '/template/index.php';
?>