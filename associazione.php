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
            <h1 class="sr-only"><?= $associazione->ragsoc ?></h1>

            <div class="border bg-light text-center p-2 mt-4">
                <h4>Codice fiscale</h4>
                <p style="font-family: monospace; font-size: 16px; letter-spacing: 2px;" class="mb-0"><?= $associazione->codfis; ?></p> 
            </div>
        </div>
        <div class="col-8">
            <div class="lead">
                <?= nl2br(htmlentities($associazione->descrizione)); ?>
            </div>

            <h4 class="mt-4">Servizi offerti</h4>

            <form action="" method="post" class="border bg-light p-2">
                <fieldset>
                    <legend>Sei volontario in questa associazione?</legend>

                </fieldset>
            </form>
            
        </div>
    </div>
</div>
<?php $contenuto = ob_get_clean(); ?>

<?php
require_once __DIR__ . '/template/index.php';
?>