<?php

use itcbonelli\donatempo\AiutoInput;
use itcbonelli\donatempo\Notifica;
use itcbonelli\donatempo\tabelle\Messaggio;
use itcbonelli\donatempo\tabelle\Richiesta;
use itcbonelli\donatempo\tabelle\Utente;

require_once __DIR__ . '/../include/main.php';
define('PERCORSO_BASE', '..');

$io = Utente::getMioUtente();
$richiesta = new Richiesta();
$richiesta->cod_stato = 'aperto';
$id_richiesta = AiutoInput::leggiIntero('id', -1, 'G');

$azione = AiutoInput::leggiStringa('azione', '', 'P');

if ($azione == 'invia_messaggio') {
    $mess = new Messaggio();
    $mess->id_richiesta = $richiesta->id_richiesta;
    $mess->id_mittente = $io->id_utente;
    $mess->id_destinatario = $richiesta->richiedente;
    $mess->contenuto = AiutoInput::leggiStringa('messaggio', '', 'P');
    $mess->data_invio = new DateTime('now', new DateTimeZone(TIMEZONE));
    $mess->salva();
}
?>
<?php ob_start(); ?>


<div class="container">
    <div class="row">
        <div class="col-12">

            <?php Notifica::MostraNotifiche(); ?>

            <h1>Dettaglio richiesta</h1>

            <dl>
                <dt><i class="fa fa-calendar" aria-hidden="true"></i> Data inserimento</dt>
                <dd>Mar, 5 febbario 2021</dd>
                <dt><i class="fa fa-user" aria-hidden="true"></i> Richiedente</dt>
                <dd>Tizio</dd>
                <dt><i class="fa fa-hand-o-right" aria-hidden="true"></i> Servizio richiesto</dt>
                <dd>Commissioni</dd>
                <dt>Stato di avanzamento</dt>
                <dd><span class="badge badge-warning">in corso</span></dd>
                <dt><i class="fa fa-sticky-note" aria-hidden="true"></i> Note</dt>
                <dd>Lorem ipsum dolor sit amet consectetur adipisicing elit. Error aliquid incidunt mollitia asperiores ex tempore laborum nostrum, tempora fugit! Voluptatibus doloribus inventore molestiae voluptatum eius adipisci quibusdam eligendi dolore ex!</dd>
            </dl>

            <hr />

            <h2><i class="fa fa-quote-left" aria-hidden="true"></i> Messaggi</h2>

            <blockquote class="border p-2">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Laborum a cumque incidunt deserunt eligendi corporis. Quidem illum eaque quo tenetur! Unde eum fugit voluptatem delectus odit dicta ducimus architecto minima.</p>
                <p class="text-muted text-right mb-0"><cite>Tizio</cite>, data</p>
            </blockquote>
            <?php if ($richiesta->cod_stato == 'aperto') : ?>
                <hr />

                <form action="" method="post">
                    <fieldset>
                        <legend>Rispondi</legend>

                        <label for="messaggio" class="sr-only"></label>
                        <div class="input-group">
                            <textarea name="messaggio" id="messaggio" class="form-control" style="background-color:lightgoldenrodyellow"></textarea>
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary" name="azione" value="invia_messaggio"><i class="fa fa-paper-plane" aria-hidden="true"></i><br /><small>Invia</small></button>
                            </div>
                        </div>

                    </fieldset>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $contenuto = ob_get_clean(); ?>

<?php
require_once __DIR__ . '/../template/index.php';
?>