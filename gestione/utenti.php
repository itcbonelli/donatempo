<?php
$titolo_pagina = "Gestione utenti";
$link_attivo = 'utenti';
ob_start();
//la funzione ob_start cattura l'output anziché mandarlo al browser
?>
<h1>Gestione utenti</h1>

<p>
    <a class="btn btn-primary" href="utente-add.php" role="button"><i class="fa fa-user-plus" aria-hidden="true"></i> Crea utente</a>
</p>

<table>
    <table border="1" cellpadding="4" id="tabella_utente" class="table table-bordered table-striped table-hover table-sm table-responsive">
        <thead>
            <tr>
                <th>Identificativo</th>
                <th>Nome utente</th>
                <th>Email</th>
                <th>Data creazione</th>
                <th>Data ultimo accesso</th>
                
                <th>attivo</th>
                <th>eliminato</th>
                <th>telefono</th>
                <th>volontario</th>
            </tr>
        <tbody>
            <tr>
                <td class="text-center">1</td>
                <td>federico.flecchia</td>
                <td>federico.flecchia@outlook.com</td>
                <td>11/03/2021</td>
                <td>22/03/2021</td>
                
                <td class="text-center">
                    <input type="checkbox" />
                </td>
                <td class="text-center">
                    <input type="checkbox" />
                </td>
                <td>123-456789</td>
                <td class="text-center">
                    <input type="checkbox" />
                </td>
            </tr>
        </tbody>
    </table>


    <?php
    //la funzione ob_get_clean recupera l'output catturato e lo restituisce a una variabile.
    $contenuto = ob_get_clean();
    require(__DIR__ . '/template/pagina.php');
    ?>