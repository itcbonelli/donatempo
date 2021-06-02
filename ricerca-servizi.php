<?php
//carico il file principale

use itcbonelli\donatempo\AiutoHTML;
use itcbonelli\donatempo\AiutoInput;
use itcbonelli\donatempo\tabelle\Provincia;
use itcbonelli\donatempo\tabelle\Servizio;

require_once __DIR__ . '/include/main.php';

$servizi = Servizio::elencoServizi(true);
$province = Provincia::caricaTutte();
$provincia = '';

$comune=AiutoInput::leggiStringa('comune', '', 'G');

?>
<?php ob_start(); ?>

<form action="ricerca-servizi-step2.php" method="GET">
    <div class="section" id="step1">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1><i class="fa fa-question-circle" aria-hidden="true"></i> Cosa possiamo fare per te?</h1>
                </div>
            </div>
            <div class="">
                <?php foreach ($servizi as $serv) : ?>
                    <div>
                        <label for="id_servizio_<?php echo $serv->id_servizio; ?>" class="d-block">
                            <div class="card">
                                <div class="card-header">
                                    <h5>
                                        <input type="radio" name="id_servizio" id="id_servizio_<?php echo $serv->id_servizio; ?>" value="<?php echo $serv->id_servizio; ?>" required />
                                        <?php echo $serv->nome; ?>
                                    </h5>
                                </div>
                            </div>
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="section" id="step2">
        <div class="container">

            <h1><i class="fa fa-map-marker" aria-hidden="true"></i> Dove?</h1>

            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="provincia">Provincia</label>
                        <select name="provincia" id="provincia" class="form-control form-control-lg">
                            <option value="" selected disabled>---</option>
                            <?php AiutoHTML::options($province, 'sigla', 'denominazione', $provincia); ?>
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="comune">Comune</label>
                        <select name="comune" id="comune" class="form-control form-control-lg">
                            <?php AiutoHTML::optionsComuni($comune); ?>
                        </select>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="section" id="step3">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h1><i class="fa fa-calendar-o" aria-hidden="true"></i> Quando?</h1>
                </div>
            </div>
            <div class="row py-2 pb-4">
                <div class="col">
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="setDateRiferimento('oggi');">Oggi</button>
                    <button type="button" class="btn btn-outline-secondary btn-sm">Domani</button>
                    <button type="button" class="btn btn-outline-secondary btn-sm">In settimana</button>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="data_iniziale">Data iniziale</label>
                        <input type="date" class="form-control" name="data_iniziale" id="data_iniziale" aria-describedby="dataInizialeHelp" placeholder="">
                        <small id="dataInizialeHelp" class="form-text text-muted">Inserisci la prima data utile</small>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="data_finale">Data finale</label>
                        <input type="date" class="form-control" name="data_finale" id="data_finale" aria-describedby="dataInizialeHelp" placeholder="">
                        <small id="dataInizialeHelp" class="form-text text-muted">Inserisci l'ultima data utile</small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <button type="submit" class="btn btn-primary btn-lg">Vedi disponibilità</button>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    var cal_data_inizio = document.getElementById('data_iniziale');
    var cal_data_fine = document.getElementById('data_finale');

    function setDateRiferimento(quando) {
        if (quando == 'oggi') {
            cal_data_inizio.valueAsDate = new Date(Date.now());
            cal_data_fine.valueAsDate = new Date(Date.now());
        }
    }
</script>

<?php $contenuto = ob_get_clean(); ?>

<?php
require_once __DIR__ . '/template/index.php';
?>