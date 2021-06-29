<?php

require_once __DIR__ . '/../include/main.php';
define('PERCORSO_BASE', '..');

?>
<?php ob_start(); ?>


<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Spese da rimborsare</h1>

                <p>
                    <a href="aggiungi-spesa.php" class="btn btn-success btn-sm"><i class="fa fa-plus" aria-hidden="true"></i> Aggiungi</a>
                </p>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Rif. richiesta</th>
                            <th>Data</th>
                            <th>Associazione</th>
                            <th>Importo</th>
                            <th>Stato</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>12</td>
                            <td>01/02/2023</td>
                            <td>Croce Rossa Italiana</td>
                            <td>€ 50,00</td>
                            <td>
                                <span class="badge badge-success"><i class="fa fa-check" aria-hidden="true"></i> Rimborsato</span>
                                <span class="badge badge-info"><i class="fa fa-gift" aria-hidden="true"></i> Offerto</span>
                                <span class="badge badge-warning"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Da rimborsare</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $contenuto = ob_get_clean(); ?>

<?php
require_once __DIR__ . '/../template/index.php';
?>