<?php
//carico il file principale
require_once __DIR__ . '/../include/main.php';
define('PERCORSO_BASE', '..');
?>
<?php ob_start(); ?>


<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Le mie disponibilità di tempo</h1>

            <form action="" method="get">

            </form>

            <form action="" method="post">

            </form>

            <form action="" method="post">
                <fieldset class="group-box">
                    <legend>Aggiungi disponibilità</legend>
                    <div class="row">
                        <div class="form-group col">
                            <label for="associazione">Associazione</label>
                            <select name="associazione" class="form-control" id="associazione">
                                <option value="" selected disabled>Selezionare</option>
                            </select>
                        </div>
                        <div class="form-group col">
                            <label for="data_disp">Data</label>
                            <input type="date" name="data_disp" id="data_disp" class="form-control" />
                        </div>
                        <div class="form-group col">
                            <label for="ora_inizio">Ora inizio</label>
                            <input type="time" name="ora_inizio" id="ora_inizio" class="form-control" />
                        </div>
                        <div class="form-group col">
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
<?php $contenuto = ob_get_clean(); ?>

<?php
require_once __DIR__ . '/../template/index.php';
?>