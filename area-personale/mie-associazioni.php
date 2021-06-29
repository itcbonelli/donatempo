<?php
//carico il file principale

use itcbonelli\donatempo\AiutoInput;
use itcbonelli\donatempo\Notifica;
use itcbonelli\donatempo\tabelle\Associazione;
use itcbonelli\donatempo\tabelle\PartecipazioneAssociazione;
use itcbonelli\donatempo\tabelle\Utente;

require_once __DIR__ . '/../include/main.php';
define('PERCORSO_BASE', '..');

$io = Utente::getMioUtente();


$azione = AiutoInput::leggiStringa('azione', '', 'P');

if ($azione == 'partecipa_associazione') {
    $part = new PartecipazioneAssociazione();
    $part->id_associazione = AiutoInput::leggiIntero('id_associazione', -1, 'P');
    $part->id_utente = $io->id_utente;
    $part->confermato = false;
    $part->salva();
} elseif ($azione == 'rimuovi') {
    $rimuovi_partecipazione = AiutoInput::leggiIntero('rimuovi_partecipazione', -1, 'P');
    $part = new PartecipazioneAssociazione();
    $part->carica($rimuovi_partecipazione);
    $part->elimina();
    Notifica::accoda('Partecipazione all\'associazione eliminata', Notifica::TIPO_SUCCESSO);
}



$partecipazioni = PartecipazioneAssociazione::getPartecipazioniUtente($io->id_utente);

?>
<?php ob_start(); ?>

<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <?php Notifica::MostraNotifiche(); ?>

                <h1>Le mie associazioni</h1>

                <p class="lead">In questa pagina vedi le associazioni in cui presti servizio come volontario.</p>

                <?php if (count($partecipazioni)) : ?>
                    <div class="card-deck">
                        <?php foreach ($partecipazioni as $part) :
                            $associazione = $part->getAssociazione();
                        ?>
                            <div class="card" style="max-width: 320px">
                                <div class="card-header bg-white">
                                    <div class="segnaposto-immagine" style="text-align:center; height: 256px; line-height: 256px;">
                                        <img class="card-img-top" src="../uploads/loghi-associazioni/<?= $associazione->url_logo ?>" alt="<?= $associazione->ragsoc ?>" style="max-height: 256px" />
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h4 class="card-title"><?php echo $associazione->ragsoc; ?></h4>
                                    <p class="card-text">
                                        <?php if ($part->confermato) :  ?>
                                            <span class="badge badge-success">Confermato</span>
                                        <?php else : ?>
                                    <form action="" method="post">
                                        <input type="hidden" name="rimuovi_partecipazione" value="<?= $part->id_partecipazione; ?>">
                                        <span class="badge badge-warning">In attesa di conferma</span>
                                        <button type="submit" class="btn btn-sm btn-outline-danger" name="azione" value="rimuovi">Rimuovi</button>
                                    </form>

                                <?php endif; ?>
                                </p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else : ?>
                    <div class="border p-2 py-4 bg-light my-2">
                        <p class="lead text-center text-muted mb-0">
                            <i class="fa fa-building fa-3x" aria-hidden="true"></i><br />
                            Non appartieni ancora ad un'associazione
                        </p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<div class="section">
    <div class="container">
        <div class="row">
            <div class="col">
                <form action="" method="post">
                    <fieldset>
                        <legend>Partecipa ad un'associazione</legend>

                        <div class="form-group">
                            <label for="id_associazione">Seleziona un'associazione</label>
                            <select class="form-control" name="id_associazione" id="id_associazione">
                                <option selected disabled></option>
                                <?php
                                $associazioni = Associazione::elencoAssociazioni();
                                foreach ($associazioni as $associazione) {
                                    echo "<option value='{$associazione->id_associazione}'>{$associazione->ragsoc}</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary" name="azione" value="partecipa_associazione">Richiedi partecipazione</button>
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