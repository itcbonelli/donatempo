<?php

use itcbonelli\donatempo\AiutoInput;
use itcbonelli\donatempo\Notifica;
use itcbonelli\donatempo\tabelle\Provincia;

require_once __DIR__ . '/../include/main.php';
$titolo_pagina = "Modifica provincia - Gestione Donatempo";
$link_attivo = 'provincia-edit';

$provincia = new Provincia();

$sigla = AiutoInput::leggiStringa('sigla', '', 'G');
if (!empty($sigla)) {
    $provincia->carica($sigla);
}

if ($_POST) {
    $azione = $_POST['azione'];

    if ($azione == 'salva') {

        $provincia->sigla = $_POST['sigla'];
        $provincia->denominazione = $_POST['denominazione'];
        $provincia->regione = $_POST['regione'];
        if ($provincia->salva()) {
            Notifica::accoda("Provincia salvata correttamente", Notifica::TIPO_SUCCESSO);
        } else {
            Notifica::accoda("Errore durante il salvataggio", Notifica::TIPO_ERRORE);
        }
    } else if ($azione == 'elimina') {
        $eli = $provincia->elimina();
        if ($eli) {
            Notifica::accoda("Provincia eliminata correttamente", Notifica::TIPO_SUCCESSO);
            Notifica::salva();
            header("location: province.php");
        } else {
            Notifica::accoda("Errore durante l'eliminazione", Notifica::TIPO_ERRORE);
        }

        exit();
    }
}

ob_start();
//la funzione ob_start cattura l'output anziché mandarlo al browser
?>
<h1><?= empty($sigla) ? 'Inserimento provincia' : 'Modifica provincia'; ?></h1>
<p><a href="province.php">&larr; Torna all'elenco delle province</a></p>
<form action="" method="post">
    <?php Notifica::MostraNotifiche(); ?>

    <div class="form-group">
        <label for="sigla">Sigla provincia</label>
        <input type="text" name="sigla" id="sigla" maxlength="2" minlength="1" required value="<?php echo $provincia->sigla; ?>" class="form-control" />
    </div>
    <div class="form-group">
        <label for="denominazione">denominazione</label><br />
        <input type="text" name="denominazione" id="denominazione" minlength="1" maxlength="50" value="<?php echo $provincia->denominazione; ?>" class="form-control" />
    </div>
    <div class="form-group">
        <label for="regione">regione</label><br />
        <input type="text" name="regione" id="regione" maxlength="50" value="<?php echo $provincia->regione; ?>" class="form-control" />
    </div>
    <div class="form-group">
        <button type="submit" name="azione" value="salva" class="btn btn-primary">Salva</button>
    </div>
</form>

<?php if (!empty($sigla)) : ?>
    <form action="" method="post">
        <button type="submit" name="azione" value="elimina" class="btn btn-danger" onclick="return confirm('Confermare eliminazione della provincia selezionata?')"><i class="fa fa-trash-o" aria-hidden="true"></i> Elimina</button>
    </form>
<?php endif; ?>
<?php
//la funzione ob_get_clean recupera l'output catturato e lo restituisce a una variabile.
$contenuto = ob_get_clean();
require(__DIR__ . '/template/pagina.php');
?>