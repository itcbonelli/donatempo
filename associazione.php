<?php
//carico il file principale

use itcbonelli\donatempo\AiutoInput;
use itcbonelli\donatempo\tabelle\Associazione;
use itcbonelli\donatempo\tabelle\PartecipazioneAssociazione;
use itcbonelli\donatempo\tabelle\Utente;

require_once __DIR__ . '/include/main.php';

$id = AiutoInput::leggiIntero('id', -1, 'G');
$io = Utente::getMioUtente();
if ($id == -1) {
    throw new RuntimeException("Identificativo associazione non valido");
}
$associazione = new Associazione();
$associazione->carica($id);

$servizi = $associazione->getServizi();
$settori = $associazione->getSettori();

$azione = AiutoInput::leggiStringa('azione', '', 'P');

if ($azione == 'partecipa' && $io) {
    $partecipazione = new PartecipazioneAssociazione();
    $partecipazione->id_associazione = $id;
    $partecipazione->id_utente = $io->id_utente;
    $partecipazione->salva();
}

?>
<?php ob_start(); ?>

<div class="container my-4">
    <div class="row">

        <div class="col" style="min-width: 320px; width: 33%">

            <img src="uploads/loghi-associazioni/<?= $associazione->url_logo ?>" alt="Logo associazione" class="img-fluid" />
            <h1 class="sr-only"><?= $associazione->ragsoc ?></h1>

            <div class="border bg-light text-center p-2 mt-4">
                <h4>Codice fiscale</h4>
                <p style="font-family: monospace; font-size: 16px; letter-spacing: 2px;" class="mb-0"><?= $associazione->codfis; ?></p>
            </div>
        </div>
        <div class="col" style="min-width: 320px">
            <div class="lead">
                <?= nl2br(htmlentities($associazione->descrizione)); ?>
            </div>

            <h4 class="mt-4">Settori di appartenenza</h4>
            <p>
                <?php foreach($settori as $settore) : ?>
                    <span class="badge badge-light border p-2"><?= $settore->nome; ?></span>
                <?php endforeach; ?>
            </p>

            <h4 class="mt-4">Servizi offerti</h4>
            <p>
                <?php foreach($servizi as $servizio) : ?>
                    <span class="badge badge-light border p-2"><?= $servizio->nome; ?></span>
                <?php endforeach; ?>
            </p>


            <?php if ($io) : ?>
                <form action="" method="post" class="border bg-light p-2">
                    <fieldset>
                        <legend>Sei volontario in questa associazione?</legend>
                        <button class="btn btn-success" name="azione" value="partecipa">Partecipa ora</button>

                        <p class="mt-2 mb-0">Attenzione: la tua richiesta dovrà essere approvata dall'associazione, che potrebbe contattarti per avere maggiori informazioni.</p>
                    </fieldset>
                </form>
            <?php endif; ?>

        </div>
    </div>
</div>
<?php $contenuto = ob_get_clean(); ?>

<?php
require_once __DIR__ . '/template/index.php';
?>