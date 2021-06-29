<?php
//carico il file principale

use itcbonelli\donatempo\AiutoHTML;
use itcbonelli\donatempo\AiutoInput;
use itcbonelli\donatempo\Notifica;
use itcbonelli\donatempo\tabelle\Associazione;
use itcbonelli\donatempo\tabelle\PartecipazioneAssociazione;
use itcbonelli\donatempo\tabelle\Utente;

require_once __DIR__ . '/../include/main.php';
define('PERCORSO_BASE', '..');

$id_associazione = AiutoInput::leggiIntero('id', -1, 'G');

$associazione=new Associazione();
if($id_associazione>-1) {
    $associazione->carica($id_associazione);
}

$io = Utente::getMioUtente();

$azione = AiutoInput::leggiStringa('azione', '', 'P');

if ($azione == 'salva') {
}



$partecipazioni = PartecipazioneAssociazione::getPartecipazioniUtente($io->id_utente);

?>
<?php ob_start(); ?>

<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <?php Notifica::MostraNotifiche(); ?>

                <h1>Modifica associazione</h1>

                <form action="" method="post">
                    <fieldset>
                        <legend>Dati dell'associazione</legend>
                        <?php AiutoHTML::campoInput('ragsoc', 'Nome associazione', $associazione->ragsoc); ?>
                        <?php AiutoHTML::campoInput('codfis', 'Codice fiscale', $associazione->codfis); ?>
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