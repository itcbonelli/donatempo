<?php
//carico il file principale

use itcbonelli\donatempo\AiutoHTML;
use itcbonelli\donatempo\AiutoInput;
use itcbonelli\donatempo\Notifica;
use itcbonelli\donatempo\tabelle\Disponibilita;
use itcbonelli\donatempo\tabelle\Utente;

require_once __DIR__ . '/../include/main.php';
define('PERCORSO_BASE', '..');

$io = Utente::getMioUtente();
$id_disponibilita = AiutoInput::leggiIntero('id', -1, 'G');
if ($id_disponibilita == -1) {
    Notifica::accoda('Parametro identificativo disponibilità non fornito', Notifica::TIPO_ERRORE);
    Notifica::salva();
    header('location:mie-disponibilita.php');
    exit;
}
$disp = new Disponibilita();
$disp->carica($id_disponibilita);

$azione = AiutoInput::leggiStringa('azione', '', 'P');

if ($azione == 'salva') {

    $disp->id_partecipazione = AiutoInput::leggiIntero('id_partecipazione', -1, 'P');
} elseif ($azione == 'elimina') {
    $disp->elimina();
    Notifica::accoda('Disponibilità eliminata correttamente');
    Notifica::salva();
    header('location:mie-disponibilita.php');
}

?>
<?php ob_start(); ?>

<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <?php Notifica::MostraNotifiche(); ?>

                <h1><i class="fa fa-clock-o" aria-hidden="true"></i> Modifica disponibilità</h1>
                
                <p><a href="mie-disponibilita.php">&larr; Torna alle disponibilità di tempo</a></p>

                <form action="" method="post">
                    <?php AiutoHTML::campoInput('associazione', 'Associazione', $disp->getPartecipazione()->getAssociazione()->ragsoc, ['disabled' => true]); ?>

                    <div class="row">
                        <div class="col"><?php AiutoHTML::campoInput('data_disp', 'Data disponibilità', $disp->data_disp->format('Y-m-d'), ['type' => 'date']); ?></div>
                        <div class="col"><?php AiutoHTML::campoInput('ora_inizio', 'Ora inizio', $disp->ora_inizio->format('H:i'), ['type' => 'time']); ?></div>
                        <div class="col"><?php AiutoHTML::campoInput('ora_fine', 'Ora fine', $disp->ora_fine->format('H:i'), ['type' => 'time']); ?></div>
                    </div>

                </form>

                <form action="" method="post">
                    <fieldset>
                        <legend>Eliminazione</legend>
                        <button type="submit" name="azione" value="elimina" class="btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i> Elimina questa disponibilità</button>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $contenuto = ob_get_clean(); ?>

<?php
require_once __DIR__ . '/../template/index.php';
?>