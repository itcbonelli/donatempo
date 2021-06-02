<?php
//carico il file principale

use itcbonelli\donatempo\tabelle\Utente;

define('PERCORSO_BASE', '..');

require_once __DIR__ . '/../include/main.php';

$utente = Utente::getMioUtente();

?>
<?php ob_start(); ?>

<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center font-weight-light">Area riservata</h1>
            </div>
        </div>
    </div>
</div>
<div class="section">
    <div class="container">
        <div class="row">
            <?php
            function appy_icon($label, $icon, $link, $caption = '', $color = 'gray')
            {
            ?>
                <div class="col text-center">
                    <a href="<?= PERCORSO_BASE . '/' . $link ?>" class="appy-link">
                        <div>
                            <div class="appy-icon color-<?= $color ?>">
                                <i class="fa fa-<?= $icon ?>" aria-hidden="true"></i>
                            </div>
                            <div class="label">
                                <?= $label ?>
                            </div>
                            <div class="caption">
                                <?= $caption; ?>
                            </div>
                        </div>
                    </a>
                </div>
            <?php
            }

            appy_icon('Il mio profilo', 'user-circle', 'area-personale/mio-profilo.php', 'Modifica i tuoi dati personali e di contatto');
            if ($utente->volontario) {
                appy_icon('Traguardi', 'trophy', 'area-personale/riconoscimenti.php', 'Visualizza i traguardi raggiunti grazie a Dona Tempo!');
                appy_icon('Richieste', 'ticket', 'area-personale/mie-richieste.php', 'Visualizza le richieste assegnate a te');
                appy_icon('Disponibilità di tempo', 'calendar-check-o', 'area-personale/mie-disponibilita.php', 'Comunica le tue disponibilità di tempo per dare una mano');
                appy_icon('Rimborsi', 'money', 'area-personale/rimborsi-volontario.php', 'Visualizza e inserisci le spese da rimborsare');
            } else {
                appy_icon('Richieste', 'ticket', 'area-personale/mie-richieste.php', 'Visualizza le tue richieste di aiuto');
                appy_icon('Rimborsi', 'money', 'area-personale/rimborsi-utente.php', 'Visualizza le spese da rimborsare ai volontari');
            }

            ?>

        </div>
    </div>
</div>
<?php $contenuto = ob_get_clean(); ?>

<?php
require_once __DIR__ . '/../template/index.php';
?>