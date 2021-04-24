<?php
//carico il file principale

use itcbonelli\donatempo\tabelle\Utente;

require_once __DIR__ . '/include/main.php';

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
                    <a href="<?= $link ?>" class="appy-link">
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

            appy_icon('Il mio profilo', 'user-circle', 'volontario/mio-profilo.php', 'Modifica i tuoi dati personali e di contatto');
            if ($utente->volontario) {
                appy_icon('Traguardi', 'trophy', 'volontario/riconoscimenti.php', 'Visualizza i traguardi raggiunti grazie a Dona Tempo!');
                appy_icon('Richieste', 'ticket', 'volontario/mie-richieste.php', 'Visualizza le richieste assegnate a te');
                appy_icon('Disponibilità di tempo', 'calendar-check-o', 'volontario/mie-disponibilita.php', 'Comunica le tue disponibilità di tempo per dare una mano');
            }

            ?>

        </div>
    </div>
</div>
<?php $contenuto = ob_get_clean(); ?>

<?php
require_once __DIR__ . '/template/index.php';
?>