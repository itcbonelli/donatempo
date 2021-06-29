<?php
//carico il file principale

use itcbonelli\donatempo\tabelle\Richiesta;
use itcbonelli\donatempo\tabelle\Utente;

require_once __DIR__ . '/../include/main.php';
define('PERCORSO_BASE', '..');

$io = Utente::getMioUtente();
$richieste = Richiesta::ElencoRichieste();

?>
<?php ob_start(); ?>


<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Richieste di aiuto</h1>

            <div class="border p-2 bg-light my-2">
                <p class="lead text-center text-muted mb-0">
                    <i class="fa fa-ticket fa-3x" aria-hidden="true"></i><br />
                    Non sono ancora presenti richieste
                </p>
            </div>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Data e orario</th>
                        <th>Associazione</th>
                        <?php if($io->volontario): ?>
                        <th>Richiedente</th>
                        <?php endif; ?>
                        <th>Stato</th>
                        <th>Operazioni</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <?php if($io->volontario): ?>
                        <td></td>
                        <?php endif; ?>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>
</div>
<?php $contenuto = ob_get_clean(); ?>

<?php
require_once __DIR__ . '/../template/index.php';
?>