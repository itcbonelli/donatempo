<?php
//carico il file principale
require_once __DIR__ . '/../include/main.php';
define('PERCORSO_BASE', '..');
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
                        <th>Richiedente</th>
                        <th>Stato</th>
                        <th>Operazioni</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
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