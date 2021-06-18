<?php

use itcbonelli\donatempo\AiutoHTML;
use itcbonelli\donatempo\AiutoInput;
use itcbonelli\donatempo\AiutoUpload;
use itcbonelli\donatempo\Notifica;
use itcbonelli\donatempo\tabelle\Associazione;
use itcbonelli\donatempo\tabelle\PartecipazioneAssociazione;
use itcbonelli\donatempo\tabelle\Servizio;
use itcbonelli\donatempo\tabelle\Utente;

require_once __DIR__ . '/../include/main.php';

$titolo_pagina = "Modifica associazione - Gestione Donatempo";
$link_attivo = 'associazioni';
ob_start();

$id_associazione = AiutoInput::leggiIntero('id', -1, 'G');
$azione = AiutoInput::leggiStringa("azione", "", "P");

$associazione = new Associazione();

$partecipanti = [];

if ($id_associazione > 0) {
    $associazione->carica($id_associazione);
    $partecipanti = PartecipazioneAssociazione::getPartecipantiAssociazione($id_associazione);
}

switch ($azione) {
    case 'salva':
        $associazione->ragsoc = AiutoInput::leggiStringa('ragsoc');
        $associazione->codfis = AiutoInput::leggiStringa('codfis');
        $associazione->descrizione = AiutoInput::leggiStringa('descrizione');

        if ($associazione->convalida()) {
            $rimuoviLogo = AiutoInput::leggiBool('rimuovi_logo', false, 'P');
            if ($rimuoviLogo) {
                $associazione->url_logo = "";
            }

            //upload logo associazione
            if (isset($_FILES['logo'])) {
                try {
                    $au = new AiutoUpload();
                    $au->destinazione .= "/loghi-associazioni/";

                    $percorso = $au->carica('logo', AiutoUpload::sanitize($associazione->ragsoc));

                    if (!empty($percorso)) {
                        $associazione->url_logo = $percorso;
                    }
                } catch (\Throwable $th) {
                    Notifica::accoda($th->getMessage(), Notifica::TIPO_ERRORE);
                }
            }
            $associazione->salva();
        }
        break;
    case 'elimina':
        $associazione->elimina();
        break;
    case 'aggiungi_utente':
        $username = AiutoInput::leggiStringa('aggiungi_username', '', 'P');
        $id_utente = Utente::getIdByUsername($username);
        if (!empty($id_utente)) {
            $partecipazione = new PartecipazioneAssociazione();
            $partecipazione->id_utente = $id_utente;
            $partecipazione->id_associazione = $id_associazione;
            $partecipazione->salva();
            Notifica::accoda('Abbinamento utente/associazione eseguito', Notifica::TIPO_SUCCESSO);
            //devo ricaricare i partecipanti perché sono cambiati
            $partecipanti = PartecipazioneAssociazione::getPartecipantiAssociazione($id_associazione);
        } else {
            Notifica::accoda('Utente non trovato', Notifica::TIPO_ERRORE);
        }
        break;
}

?>
<h1>Modifica associazione</h1>

<p><a href="associazioni.php">&larr; Torna all'elenco delle associazioni</a></p>

<?php Notifica::MostraNotifiche(); ?>

<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#tabAnagrafica" role="tab" aria-controls="tabAnagrafica" aria-selected="true">Dati anagrafici</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#tabVolontari" role="tab" aria-controls="profile" aria-selected="false">Volontari</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#tabServizi" role="tab" aria-controls="contact" aria-selected="false">Servizi</a>
    </li>
</ul>
<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="tabAnagrafica" role="tabpanel" aria-labelledby="home-tab">
        <form action="" method="post" enctype="multipart/form-data">
            <fieldset>
                <legend>Dati dell'associazione</legend>
                <div class="form-group">
                    <label for="ragsoc">Ragione sociale</label>
                    <input type="text" name="ragsoc" id="ragsoc" class="form-control" value="<?= htmlentities($associazione->ragsoc); ?>" />
                </div>
                <div class="form-group">
                    <label for="codfis">Codice fiscale</label>
                    <input type="text" name="codfis" id="codfis" min="1" maxlength="11" class="form-control" value="<?= htmlentities($associazione->codfis); ?>" />
                </div>

                <p>
                    <?php
                    if (!empty($associazione->url_logo)) :
                    ?>
                        <img src="../uploads/loghi-associazioni/<?= $associazione->url_logo; ?>" alt="Logo associazione" />
                <div class="form-group">
                    <label for="rimuovi_logo" class="checkbox" title="Se questa casella viene spuntata, verrà rimosso il logo attualmente caricato anche se non è stato inserito un nuovo logo.">
                        <input type="checkbox" name="rimuovi_logo" id="rimuovi_logo" value="1" /> Rimuovi logo
                    </label>
                </div>
            <?php endif; ?>
            </p>


            <div class="form-group">
                <label for="logo">Logo</label>
                <input type="file" name="logo" id="logo" class="form-control" />
            </div>

            <div class="form-group">
                <label for="descrizione">Descrizione</label>
                <input type="text" name="descrizione" id="descrizione" class="form-control" value="<?= htmlentities($associazione->descrizione); ?>" />
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary" name="azione" value="salva">Salva</button>
                <button type="submit" class="btn btn-outline-danger" name="azione" value="elimina" onclick="return confirm('Confermare l\'eliminazione dell\'associazione?')">Elimina</button>
            </div>
            </fieldset>
        </form>
    </div>
    <div class="tab-pane fade" id="tabVolontari" role="tabpanel" aria-labelledby="profile-tab">
        <?php if ($id_associazione > 0) : ?>
            <form action="" method="post">
                <fieldset>
                    <legend>Utenti partecipanti</legend>

                    <table class="table table-bordered table-striped table-hover table-sm">
                        <thead>
                            <tr>
                                <th><input type="checkbox" readonly disabled /></th>
                                <th>Nome utente</th>
                                <th>Cognome</th>
                                <th>Nome</th>
                                <th>Ruolo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (count($partecipanti)) :
                                foreach ($partecipanti as $part) :
                                    //var_dump($part);
                                    $ut = $part->getUtente();
                            ?>
                                    <tr>
                                        <td><input type="checkbox" name="partecipante[<?= $part->id_partecipazione; ?>]" /></td>
                                        <td><?= $ut->username; ?></td>
                                        <td><?= $ut->getProfilo()->cognome; ?></td>
                                        <td><?= $ut->getProfilo()->nome; ?></td>
                                        <td><?= $part->ruolo; ?></td>
                                    </tr>
                                <?php
                                endforeach;
                            else :
                                ?>
                                <tr>
                                    <td colspan="5" class="text-center">Non sono presenti partecipanti</td>
                                </tr>
                            <?php
                            endif;
                            ?>
                        </tbody>
                    </table>
                </fieldset>
            </form>
            <hr />
            <form action="" method="post">
                <fieldset>
                    <legend>Aggiungi utente</legend>

                    <div class="form-group">
                        <label for="aggiungi_username">Nome utente:</label>
                        <input type="text" name="aggiungi_username" id="aggiungi_username" class="form-control" />
                    </div>

                    <div class="form-group">
                        <label for="ruolo">Ruolo</label>
                        <select name="ruolo" id="ruolo" class="form-control">
                            <option value="volontario">Volontario</option>
                            <option value="gestore">Gestore</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" name="azione" value="aggiungi_utente">Aggiungi</button>
                    </div>
                </fieldset>
            </form>
        <?php else : ?>
            <div class="alert alert-warning">Per gestire questa funzione è necessario prima salvare l'associazione</div>
        <?php endif; ?>
    </div>
    <div class="tab-pane fade" id="tabServizi" role="tabpanel" aria-labelledby="contact-tab">
        <?php if ($id_associazione > 0) : ?>
            <hr />
            <form action="" method="post">
                <fieldset>
                    <legend>Aggiungi servizio</legend>

                    <div class="form-group">
                        <label for="aggiungi_servizio">Seleziona un servizio</label>
                        <select name="aggiungi_servizio" id="aggiungi_servizio" class="form-control">
                            <?php
                            $servizi_tutti = Servizio::elencoServizi(true);
                            AiutoHTML::options($servizi_tutti, 'id_servizio', 'nome');
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Conferma</button>
                    </div>
                </fieldset>
            </form>
        <?php else : ?>
            <div class="alert alert-warning">Per gestire questa funzione è necessario prima salvare l'associazione</div>
        <?php endif; ?>
    </div>
</div>


<?php
//la funzione ob_get_clean recupera l'output catturato e lo restituisce a una variabile.
$contenuto = ob_get_clean();
require(__DIR__ . '/template/pagina.php');
?>