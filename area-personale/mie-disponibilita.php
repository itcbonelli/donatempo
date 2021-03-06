<?php
//carico il file principale

use itcbonelli\donatempo\AiutoData;
use itcbonelli\donatempo\AiutoDB;
use itcbonelli\donatempo\AiutoInput;
use itcbonelli\donatempo\calendario\Appuntamento;
use itcbonelli\donatempo\calendario\Calendario;
use itcbonelli\donatempo\Notifica;
use itcbonelli\donatempo\tabelle\Associazione;
use itcbonelli\donatempo\tabelle\Disponibilita;
use itcbonelli\donatempo\tabelle\PartecipazioneAssociazione;
use itcbonelli\donatempo\tabelle\Servizio;
use itcbonelli\donatempo\tabelle\Utente;

require_once __DIR__ . '/../include/main.php';
define('PERCORSO_BASE', '..');

$io = Utente::getMioUtente();
$partecipazioni = PartecipazioneAssociazione::getPartecipazioniUtente($io->id_utente);
$associazioni = Associazione::getMieAssociazioni();
$mese = AiutoInput::leggiIntero('mese', intval(date('m')));
$anno = AiutoInput::leggiIntero('anno', intval(date('Y')));
$cal = new Calendario($mese, $anno);

$servizi = Servizio::elencoServizi(true);

$azione = AiutoInput::leggiStringa('azione', '', 'P');

if ($azione == 'aggiungi') {
    $disp = new Disponibilita();
    
    $disp->id_partecipazione = AiutoInput::leggiIntero('id_partecipazione', -1, 'P');
    $disp->data_disp = AiutoInput::leggiData('data_disp', null, 'P');
    $disp->ora_inizio = AiutoInput::leggiOrario('ora_inizio', null, 'P');
    $disp->ora_fine = AiutoInput::leggiOrario('ora_fine', null, 'P');

    $salva = $disp->salva();
    if ($salva) {

        $serviziInclusi = $_POST['servizi'];

        foreach ($serviziInclusi as $si) {
            $adb = new AiutoDB($dbconn);
            $q = "INSERT INTO disponibilita_include_servizi (id_disponibilita, id_servizio) VALUES (:d, :s)";
            $p = ['d' => $disp->id_disponibilita, 's' => $si];
           
            $adb->eseguiComando($q, $p);
        }
    } else {
        Notifica::accoda('Si è verificato un errore salvando la disponibilità', Notifica::TIPO_ERRORE); 
    }
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
        <?php
        $elencoDisp = Disponibilita::getDisponibilitaUtente($io->id_utente, $anno, $mese);
        //var_dump($elencoDisp);
        foreach ($elencoDisp as $dsp) {
            $appu = new Appuntamento();
            $appu->descrizione = strval($dsp['associazione']);
            $appu->data = DateTime::createFromFormat('Y-m-d', $dsp['data_disp']);
            $appu->ora_inizio = DateTime::createFromFormat('H:i:s', $dsp['ora_inizio']);
            $appu->ora_fine = DateTime::createFromFormat('H:i:s', $dsp['ora_fine']);
            $appu->link = "disponibilita-edit.php?id={$dsp['id_disponibilita']}";
            $cal->appuntamenti[] = $appu;
        }
        $cal->calendario();
        ?>
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
                                        //se la partecipazione non è confermata salto all'iterazione successiva
                                        if ($partecipazione->confermato == false) {
                                            continue;
                                        }
                                        $assoc = $partecipazione->getAssociazione();
                                    ?>
                                        <option value="<?= $partecipazione->id_partecipazione; ?>"><?= $assoc->ragsoc; ?></option>
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
                                    <?php
                                    foreach ($servizi as $servizio) {
                                        echo "<label class='checkbox'><input type='checkbox' name='servizi[]' value='{$servizio->id_servizio}' checked /> {$servizio->nome}</label><br />";
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