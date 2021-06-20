<?php

use itcbonelli\donatempo\AiutoHTML;
use itcbonelli\donatempo\AiutoInput;
use itcbonelli\donatempo\Notifica;
use itcbonelli\donatempo\tabelle\Disponibilita;

require_once __DIR__ . '/../include/main.php';
$titolo_pagina = "Modifica disponibilità di tempo - Gestione Donatempo";
$link_attivo = 'disponibilita';

$id_disp = AiutoInput::leggiIntero('id', -1, 'G');

$disponibilita = new Disponibilita();

if ($id_disp > 0) {
    $disponibilita->carica($id_disp);
    $partecipazione = $disponibilita->getPartecipazione();
    $volontario = $partecipazione->getUtente();
}

$azione = AiutoInput::leggiStringa('azione', '', 'P');
if ($azione == 'salva') {
    
} elseif($azione=='elimina') {
    if($disponibilita->elimina()) {
        Notifica::accoda('Disponibilità eliminata correttamente', Notifica::TIPO_SUCCESSO);
        Notifica::salva();
        header('location: disponibilita.php');
    } else {
        Notifica::accoda('Si è verificato un errore con l\'eliminazione della disponibilità', Notifica::TIPO_ERRORE);
    }
    
}

ob_start();
?>

<h1>Modifica disponibilità di tempo</h1>

<p>
    <a href="disponibilita.php">&larr; Torna all'elenco delle disponibilità</a>
</p>

<form action="" method="post">
    <?php AiutoHTML::campoInput('data_disp', 'Data disponibilità', $disponibilita->data_disp, ['type' => 'date']) ?>
    <?php AiutoHTML::campoInput('ora_inizio', 'Ora inizio', $disponibilita->ora_inizio, ['type' => 'time']) ?>
    <?php AiutoHTML::campoInput('ora_fine', 'Ora fine', $disponibilita->ora_fine, ['type' => 'time']) ?>

    
    
    <div class="form-group">
        <button type="submit" class="btn btn-primary" name="azione" value="salva">Salva</button>
        
    </div>
</form>

<form action="" method="post">
    <fieldset>
        <legend>Elimina disponibilità</legend>
        <button type="submit" class="btn btn-danger" name="azione" value="elimina" onclick="return confirm('Eliminare questa disponibilità di tempo?');">Elimina</button>
    </fieldset>
</form>
<?php

$contenuto = ob_get_clean();
require(__DIR__ . '/template/pagina.php');
?>