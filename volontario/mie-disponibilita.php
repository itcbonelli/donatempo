<?php
//carico il file principale

use itcbonelli\donatempo\AiutoInput;
use itcbonelli\donatempo\calendario\Calendario;
use itcbonelli\donatempo\tabelle\Associazione;

require_once __DIR__ . '/../include/main.php';
define('PERCORSO_BASE', '..');

$associazioni = Associazione::elencoAssociazioni();
$mese = AiutoInput::leggiIntero('mese', intval(date('m')));
$anno = AiutoInput::leggiIntero('anno', intval(date('Y')));
$cal=new Calendario();



?>
<?php ob_start(); ?>

<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1><i class="fa fa-clock-o" aria-hidden="true"></i> Le mie disponibilità di tempo</h1>
            </div>
        </div>
    </div>
</div>
<div class="section">
    <div class="container">
        <?php $cal->render(); ?>
    </div>
</div>
<div class="section">
    <div class="container">
        <div class="row">
            <div class="col">
                <form action="" method="post">
                    <fieldset class="group-box">
                        <legend>Aggiungi disponibilità</legend>
                        <div class="row">
                            <div class="form-group col">
                                <label for="associazione">Associazione</label>
                                <select name="associazione" class="form-control" id="associazione" style="min-width: 320px;">
                                    <option value="" selected disabled>Selezionare</option>
                                    <?php foreach ($associazioni as $assoc) : ?>
                                        <option value="<?= $assoc->id_associazione; ?>"><?= $assoc->ragsoc; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group col" style="min-width: 200px;">
                                <label for="data_disp">Data</label>
                                <input type="date" name="data_disp" id="data_disp" class="form-control" />
                            </div>
                            <div class="form-group col" style="min-width: 200px;">
                                <label for="ora_inizio">Ora inizio</label>
                                <input type="time" name="ora_inizio" id="ora_inizio" class="form-control" />
                            </div>
                            <div class="form-group col" style="min-width: 200px;">
                                <label for="ora_fine">Ora fine</label>
                                <input type="time" name="ora_fine" id="ora_fine" class="form-control" />
                            </div>
                            <div class="form-group col" style="align-self:flex-end">
                                <button type="submit" class="btn btn-primary">conferma</button>
                            </div>
                        </div>
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