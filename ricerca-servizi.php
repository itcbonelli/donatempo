<?php 
//carico il file principale
require_once __DIR__ . '/include/main.php';

?>
<?php ob_start(); ?>

    <div class="container">
        <div class="row">
            <div class="col-3">
                <h3>Ricerca servizi</h3>

                <form action="">

                    <fieldset class="group-box">
                        <legend>Cosa?</legend>
                        <div class="form-group">
                            <label for="id_servizio">Scegli un servizio</label>
                            <select name="id_servizio" id="id_servizio" class="form-control">
                                <option value="" selected disabled>Selezionare...</option>
                            </select>
                        </div>
                    </fieldset>

                    <fieldset class="group-box">
                        <legend>Quando?</legend>
                    <div class="form-group">
                      <label for="data_inizio">Data inizio</label>
                      <input type="date" name="data_inizio" id="data_inizio" class="form-control" />
                    </div>
                    <div class="form-group">
                        <div class="form-label">Orario</div>
                        <input type="time" name="orario" class="form-control" />
                    </div>
                    </fieldset>
                </form>
            </div>
            <div class="col-9">

            </div>
        </div>
    </div>
<?php $contenuto = ob_get_clean(); ?>

<?php
require_once __DIR__ . '/template/index.php';
?>