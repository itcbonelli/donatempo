<?php
//carico il file principale

use itcbonelli\donatempo\AiutoHTML;
use itcbonelli\donatempo\AiutoInput;
use itcbonelli\donatempo\tabelle\Comune;
use itcbonelli\donatempo\tabelle\Provincia;
use itcbonelli\donatempo\tabelle\Utente;

require_once __DIR__ . '/../include/main.php';

$province = Provincia::caricaTutte();
$comuni = Comune::getElencoComuni();
$profilo = Utente::getMioUtente()->getProfilo();

define('PERCORSO_BASE', '..');
?>
<?php ob_start(); ?>


<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Il mio profilo</h1>

            <form action="" method="post" class="border radius p-2 px-3 mb-2 bg-light" enctype="multipart/form-data">
                <fieldset>
                    <legend><i class="fa fa-id-card" aria-hidden="true"></i> Dati anagrafici</legend>
                </fieldset>

                <div class="row">
                    <div class="col text-center" style="min-width: 256px; max-width: 256px">
                        <div class="form-group">
                            <div class="foto-profilo shadow">
                                <div class="foto-profilo-overlay" title="Fai clic qui per caricare una nuova foto profilo" onclick="document.getElementById('upload_foto').click();">
                                    <i class="fa fa-camera" aria-hidden="true"></i>
                                </div>
                            </div>
                            <input type="file" name="upload_foto" id="upload_foto" class="collapse" />
                        </div>
                        <button type="submit" name="azione" value="rimuovi_foto" class="btn-sm btn btn-outline-danger">Rimuovi foto</button>
                    </div>
                    <div class="col">
                        <div class="row">
                            <div class="col" style="min-width: 256px">
                                <?php AiutoHTML::campoInput('nome', 'Nome', $profilo->nome); ?>
                            </div>
                            <div class="col" style="min-width: 256px">
                                <?php AiutoHTML::campoInput('cognome', 'Cognome', $profilo->cognome); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <?php AiutoHTML::campoInput('indirizzo', 'Indirizzo', $profilo->indirizzo); ?>
                            </div>
                            <div class="col">
                                <?php AiutoHTML::campoInput('cap', 'Cap', $profilo->indirizzo); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col" style="min-width: 256px">
                                <div class="form-group">
                                    <label for="provincia">Provincia</label>
                                    <select name="provincia" id="provincia" class="form-control">
                                        <?php AiutoHTML::options($province, 'sigla', 'denominazione'); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col" style="min-width: 256px">
                                <div class="form-group">
                                    <label for="comune">Comune</label>
                                    <select name="comune" id="comune" class="form-control">
                                        <?php AiutoHTML::options($comuni, 'id_comune', 'denominazione', $profilo->id_comune); ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col" style="min-width: 256px">
                                <?php AiutoHTML::campoInput('telefono1', 'Telefono 1', $profilo->telefono1); ?>
                            </div>
                            <div class="col" style="min-width: 256px">
                                <?php AiutoHTML::campoInput('telefono2', 'Telefono 2', $profilo->telefono2); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <form action="" method="post" class="border radius p-2 px-3 mb-2 bg-light">
                <fieldset>
                    <legend><i class="fa fa-key" aria-hidden="true"></i> Modifica password</legend>

                    <div class="row">
                        <div class="col" style="min-width: 256px">
                            <div class="form-group">
                                <label for="oldpwd">Password attuale</label>
                                <input type="password" name="oldpwd" id="oldpwd" class="form-control" required />
                            </div>
                        </div>
                        <div class="col" style="min-width: 256px">
                            <div class="form-group">
                                <label for="pwd1">Password</label>
                                <input type="password" name="pwd1" id="pwd1" class="form-control" required />
                            </div>
                        </div>
                        <div class="col" style="min-width: 256px">
                            <div class="form-group">
                                <label for="pwd2">Conferma password</label>
                                <input type="password" name="pwd2" id="pwd2" class="form-control" required />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Modifica password</button>
                    </div>
                </fieldset>
            </form>
            <form action="" method="post" class="border border-radius p-2 px-3 bg-light">
                <fieldset>
                    <legend><i class="fa fa-trash" aria-hidden="true"></i> Elimina il tuo account</legend>

                    <p>Proseguendo con questa operazione sospenderai l'accesso al sito web</p>

                    <div class="form-group">
                        <label for="password">Inserisci la tua password</label>
                        <input type="password" name="password" id="password" class="form-control" required />
                    </div>

                    <button type="submit" class="btn btn-danger">Disattiva il mio account</button>

                </fieldset>
            </form>
        </div>
    </div>
</div>

<script>
    var elencoProvince = [];
</script>

<?php $contenuto = ob_get_clean(); ?>

<?php
require_once __DIR__ . '/../template/index.php';
?>