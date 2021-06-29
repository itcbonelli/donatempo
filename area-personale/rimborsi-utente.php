<?php

use itcbonelli\donatempo\AiutoDB;

require_once __DIR__ . '/../include/main.php';
define('PERCORSO_BASE', '..');

$query = "SELECT rimborsi_spese.* FROM rimborsi_spese
INNER JOIN richieste ON richieste.id_richiesta=rimborsi_spese.id_richiesta";

$adb=new AiutoDB($dbconn);
$rimborsi=$adb->eseguiQuery($query);


?>
<?php ob_start(); ?>
<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Rimborsi spese</h1>

                <p>In questa pagina puoi prendere visione delle spese che i volontari hanno anticipato e che devono essere rimborsate.</p>

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
                        <?php foreach($rimborsi as $rimborso) : ?>
                        <tr>
                            <td><?= $rimborso['id_richiesta'] ?></td>
                            <td><?= $rimborso['data_spesa'] ?></td>
                            <td>Croce Rossa Italiana</td>
                            <td>€ 50,00</td>
                            <td>
                                <span class="badge badge-success"><i class="fa fa-check" aria-hidden="true"></i> Rimborsato</span>
                                <span class="badge badge-info"><i class="fa fa-gift" aria-hidden="true"></i> Offerto</span>
                                <span class="badge badge-warning"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Da rimborsare</span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
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