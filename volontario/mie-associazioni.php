<?php
//carico il file principale

use itcbonelli\donatempo\tabelle\Associazione;
use itcbonelli\donatempo\tabelle\PartecipazioneAssociazione;
use itcbonelli\donatempo\tabelle\Utente;

require_once __DIR__ . '/../include/main.php';
define('PERCORSO_BASE', '..');

$io = Utente::getMioUtente();
$partecipazioni = PartecipazioneAssociazione::getPartecipazioniUtente($io->id_utente);
?>
<?php ob_start(); ?>

<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Le mie associazioni</h1>

                <?php if (count($partecipazioni)) : ?>
                    <?php foreach($partecipazioni as $part) : 
                        $associazione = $part->getAssociazione();
                        ?>
                        <div class="card">
                            <img class="card-img-top" src="holder.js/100x180/" alt="">
                            <div class="card-body">
                                <h4 class="card-title"><?php echo $associazione->ragsoc; ?></h4>
                                <p class="card-text">
                                    <?php if($part->confermato) :  ?>
                                        <span class="badge badge-success">Confermato</span>
                                    <?php else: ?>
                                        <span class="badge badge-warning">In attesa di conferma</span>
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
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