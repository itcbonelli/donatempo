<?php
//carico il file principale

use itcbonelli\donatempo\AiutoHTML;
use itcbonelli\donatempo\AiutoInput;
use itcbonelli\donatempo\filtri\FiltroDisponibilita;
use itcbonelli\donatempo\tabelle\Comune;
use itcbonelli\donatempo\tabelle\Disponibilita;
use itcbonelli\donatempo\tabelle\Provincia;
use itcbonelli\donatempo\tabelle\Servizio;

require_once __DIR__ . '/include/main.php';

$filtro = new FiltroDisponibilita();

$servizi = Servizio::elencoServizi(true);
$id_servizio = AiutoInput::leggiIntero('id_servizio', null, 'G');
$filtro->data_inizio = AiutoInput::leggiData('data_iniziale', new DateTime(), 'G');
$filtro->data_fine = AiutoInput::leggiData('data_finale', new DateTime(), 'G');
$filtro->ora_inizio = AiutoInput::leggiData('ora_inizio', new DateTime(), 'G');
$filtro->ora_fine = AiutoInput::leggiData('ora_fine', new DateTime(), 'G');
$filtro->provincia = AiutoInput::leggiStringa('provincia', '');

$citta = AiutoInput::leggiStringa('citta', '', 'G');
$province = Provincia::caricaTutte();
$comuni = Comune::getElencoComuni();

$disponiblita = Disponibilita::ricercaDisponibilita($filtro);

$voce_attiva='servizi';
?>
<?php ob_start(); ?>
<div class="section">
    <div class="container">
        <div class="row">
            <div class="col" style="min-width: 320px;">
                <?php if (empty($disponiblita)) : ?>
                    <p class="text-center"><i class="fa fa-frown-o fa-4x" aria-hidden="true"></i></p>
                    <h4 class="text-center">Al momento non sono presenti disponibilità</h4>
                    <p class="lead text-center">Prova ad affinare la ricerca utilizzando i filtri</p>
                <?php else : ?>
                    <h4>Seleziona una disponibilità</h4>
                    <form action="">

                    </form>
                <?php endif; ?>
            </div>

            <div class="col" style="min-width: 320px; max-width: 33%">
                <form action="" method="get">
                    <fieldset>
                        <legend>La tua ricerca</legend>
                        <div class="form-group">
                            <label for="id_servizio">Servizio richiesto</label>
                            <select name="id_servizio" id="id_servizio" class="form-control">
                                <?php AiutoHTML::options($servizi, 'id_servizio', 'nome', $id_servizio); ?>
                            </select>
                        </div>
                        <?php AiutoHTML::campoInput('data_iniziale', "Data inizio", $filtro->data_inizio->format('Y-m-d'), ['type' => 'date']); ?>
                        <?php AiutoHTML::campoInput('data_finale', "Data fine", $filtro->data_fine->format('Y-m-d'), ['type' => 'date']); ?>

                        <div class="form-group">
                            <label for="ora_inizio">Orario</label>
                            <div class="input-group">
                                <input type="time" name="ora_inizio" id="ora_inizio" class="form-control" />
                                <span class="input-group-text input-group-append input-group-prepend">&dash;</span>
                                <input type="time" name="ora_fine" id="ora_fine" class="form-control" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="provincia">Provncia</label>
                            <select name="provincia" id="provincia" class="form-control form-control-sm">
                                <option value="" selected disabled></option>
                                <?php AiutoHTML::options($province, 'sigla', 'denominazione', $filtro->provincia); ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="comune">Comune</label>
                            <select name="comune" id="comune" class="form-control form-control-sm">
                                <option value="" selected disabled></option>
                                <?php AiutoHTML::options($comuni, 'id_comune', 'denominazione', $filtro->cod_comune); ?>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-outline-primary">Ricarica</button>


                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>



<?php $contenuto = ob_get_clean(); ?>

<?php
require_once __DIR__ . '/template/index.php';
?>