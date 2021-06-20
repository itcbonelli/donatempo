<?php
//carico il file principale

use itcbonelli\donatempo\AiutoInput;
use itcbonelli\donatempo\calendario\Calendario;
use itcbonelli\donatempo\Notifica;
use itcbonelli\donatempo\tabelle\Associazione;
use itcbonelli\donatempo\tabelle\Disponibilita;
use itcbonelli\donatempo\tabelle\PartecipazioneAssociazione;
use itcbonelli\donatempo\tabelle\Servizio;
use itcbonelli\donatempo\tabelle\Utente;

require_once __DIR__ . '/../include/main.php';
define('PERCORSO_BASE', '..');

$io=Utente::getMioUtente();
$partecipazioni = PartecipazioneAssociazione::getPartecipazioniUtente($io->id_utente);
$associazioni = Associazione::getMieAssociazioni();
$mese = AiutoInput::leggiIntero('mese', intval(date('m')));
$anno = AiutoInput::leggiIntero('anno', intval(date('Y')));
$cal = new Calendario($mese, $anno);

$servizi = Servizio::elencoServizi(true);

$azione = AiutoInput::leggiStringa('azione', '', 'P');

if($azione=='aggiungi') {
    $disp=new Disponibilita();
    
    $disp->id_partecipazione = AiutoInput::leggiIntero('id_partecipazione', -1, 'P');
    
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
                                <select name="id_partecipazione" class="form-control" id="id_partecipazione" style="min-width: 320px;">
                                    <option value="" selected disabled>Selezionare</option>
                                    <?php foreach ($partecipazioni as $partecipazione) : 
                                        $assoc = $partecipazione->getAssociazione();
                                        ?>
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

<?php $contenuto = ob_get_clean(); ?>

<?php
require_once __DIR__ . '/../template/index.php';
?>