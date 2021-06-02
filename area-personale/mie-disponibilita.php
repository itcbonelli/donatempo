<?php
//carico il file principale

use itcbonelli\donatempo\AiutoInput;
use itcbonelli\donatempo\calendario\Calendario;
use itcbonelli\donatempo\Notifica;
use itcbonelli\donatempo\tabelle\Associazione;
use itcbonelli\donatempo\tabelle\Servizio;

require_once __DIR__ . '/../include/main.php';
define('PERCORSO_BASE', '..');

$associazioni = Associazione::getMieAssociazioni();
$mese = AiutoInput::leggiIntero('mese', intval(date('m')));
$anno = AiutoInput::leggiIntero('anno', intval(date('Y')));
$cal = new Calendario($mese, $anno);

$servizi = Servizio::elencoServizi(true);

$azione = AiutoInput::leggiStringa('azione', '', 'P');

if($azione=='aggiungi') {

}

?>
<?php ob_start(); ?>

<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1><i class="fa fa-clock-o" aria-hidden="true"></i> Le mie disponibilità di tempo</h1>
                <?php Notifica::MostraNotifiche(); ?>
            </div>
        </div>
    </div>
</div>
<div class="section">
    <div class="container">
        <?php $cal->calendario(); ?>
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

                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="ripeti" class="checkbox"><input type="checkbox" name="ripeti" id="ripeti"> Ripeti settimanalmente fino alla seguente data</label>
                                    <input type="date" name="data_fine_ripeti" id="data_fine_ripeti" class="form-control" disabled />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <p><strong>Servizi offerti:</strong></p>
                                    <label for="tutti_servizi" class="checkbox"><input type="checkbox" name="tutti_servizi" id="tutti_servizi"> Seleziona tutti</label><br />
                                    <?php 
                                    foreach($servizi as $servizio) {
                                        echo "<label class='checkbox'><input type='checkbox' name='servizi[{$servizio->id_servizio}]' checked /> {$servizio->nome}</label><br />";
                                    }
                                    ?>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col" style="align-self:flex-end">
                                <button type="submit" class="btn btn-primary" name="azione" value="aggiungi">conferma</button>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    (function() {
        var ripeti = document.getElementById('ripeti');
        var data_fine_ripeti = document.getElementById('data_fine_ripeti');

        function ripeti_onchange() {
            data_fine_ripeti.checked = ripeti.checked;
        }

        ripeti.addEventListener('change', ripeti_onchange);
    }());
</script>
<?php $contenuto = ob_get_clean(); ?>

<?php
require_once __DIR__ . '/../template/index.php';
?>