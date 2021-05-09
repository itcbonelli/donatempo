<?php
//carico il file principale

use itcbonelli\donatempo\AiutoHTML;
use itcbonelli\donatempo\AiutoInput;
use itcbonelli\donatempo\tabelle\Servizio;

require_once __DIR__ . '/include/main.php';

$servizi = Servizio::elencoServizi(true);
$id_servizio = AiutoInput::leggiIntero('id_servizio', null, 'G');
$data_iniziale = AiutoInput::leggiData('data_iniziale', new DateTime(), 'G');
$data_finale = AiutoInput::leggiData('data_finale', new DateTime(), 'G');
$citta=AiutoInput::leggiStringa('citta', '', 'G');
?>
<?php ob_start(); ?>
<div class="section">
    <div class="container">
        <div class="row">

            <div class="col-9">
                <h4>Seleziona una disponibilità</h4>
                <form action="">

                </form>
            </div>

            <div class="col-3">
                <form action="" method="get">
                    <fieldset>
                        <legend>La tua ricerca</legend>
                        <div class="form-group">
                            <label for="id_servizio">Servizio richiesto</label>
                            <select name="id_servizio" id="id_servizio" class="form-control">
                                <?php AiutoHTML::options($servizi, 'id_servizio', 'nome', $id_servizio); ?>
                            </select>
                        </div>
                        <?php AiutoHTML::campoInput('data_iniziale', "Data inizio", $data_iniziale->format('Y-m-d'), ['type' => 'date']); ?>
                        <?php AiutoHTML::campoInput('data_finale', "Data fine", $data_finale->format('Y-m-d'), ['type' => 'date']); ?>
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