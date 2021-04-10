<?php

use itcbonelli\donatempo\Notifica;

define('PERCORSO_BASE', '..');
require_once __DIR__ . '/../include/main.php';


?>
<?php ob_start(); ?>
<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Le mie statistiche</h1>
            </div>
        </div>
        <div class="row traguardi">
            <div class="card col m-2" style="min-width: 319px">
                <div class="card-body">
                    <h1><i class="fa fa-clock-o" aria-hidden="true"></i> 123</h1>
                    <h3 class="font-weight-light">ore donate</h3>
                </div>
            </div>
            <div class="card col m-2 richieste-soddisfatte" style="min-width: 319px">
                <div class="card-body">
                    <h1> <i class="fa fa-ticket" aria-hidden="true"></i> 20</h1>
                    <h3 class="font-weight-light">richieste soddisfatte</h3>
                </div>
            </div>
            <div class="card col m-2 persone-servite" style="min-width: 319px">
                <div class="card-body">
                    <h1> <i class="fa fa-users" aria-hidden="true"></i> 5</h1>
                    <h3 class="font-weight-light">persone servite</h3>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="section bg-light">
    <div class="container">
        <div class="row">
            <div class="col">
                <h1><i class="fa fa-trophy" aria-hidden="true"></i> I miei traguardi</h1>

                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Badge</th>
                            <th>Descrizione</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>

                            </td>
                            <td>
                                <p class="mb-0">
                                    <strong>Donatempo principiante</strong><br /><span class="badge badge-success">Raggiunto il xx/xx/xxxx</span><br />
                                    Dona almeno 10 ore del tuo tempo
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>

                            </td>
                            <td>
                                <p class="mb-0">
                                    <strong>Esci dal guscio!</strong><br /><span class="badge badge-secondary">da raggiungere</span><br />
                                    Servi almeno 10 persone diverse che hanno bisogno del tuo aiuto
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>

                            </td>
                            <td>
                                <p class="mb-0">
                                    <strong>Donatempo veterano</strong><br /><span class="badge badge-secondary">da raggiungere</span><br />
                                    Dona almeno 100 ore del tuo tempo
                                </p>
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