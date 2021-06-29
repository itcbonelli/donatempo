<?php

use itcbonelli\donatempo\AiutoInput;
use itcbonelli\donatempo\Notifica;
use itcbonelli\donatempo\tabelle\Utente;

require_once __DIR__ . '/include/main.php';

$page_title = "Registrazione - DONATEMPO";

$utente = new Utente();
if ($_POST && $_POST['azione'] == 'conferma') {
    $utente->username = AiutoInput::leggiStringa('username');

    $pwd1 = AiutoInput::leggiStringa('pwd1');
    $pwd2 = AiutoInput::leggiStringa('pwd2');
    if ($pwd1 == $pwd2) {
        $utente->password = $pwd1;
    } else {
        Notifica::accoda("Le password inserite non coincidono", Notifica::TIPO_ERRORE);
    }

    $utente->email = AiutoInput::leggiStringa('email');
    $utente->telefono = AiutoInput::leggiStringa('telefono');

    $ok = true;

    if (!AiutoInput::leggiBool('accetta_tos')) {
        $ok = false;
        Notifica::accoda("È obbligatorio accettare i termini e le condizioni di utilizzo del servizio", Notifica::TIPO_ERRORE);
    }

    if (!AiutoInput::leggiBool('accetta_privacy')) {
        $ok = false;
        Notifica::accoda("È obbligatorio acconsentire al trattamento dei dati personali", Notifica::TIPO_ERRORE);
    }

    $salva = $utente->salva();
    if ($salva) {
        header('location:registrazione-eseguita.php');
    }
}

?>
<?php ob_start(); ?>
<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Registrazione</h1>

                <?php Notifica::MostraNotifiche(); ?>

                <form method="post" action="">

                    <fieldset>

                        <legend>I tuoi dati personali</legend>

                        <div class="form-group">
                            <label for="username">Nome utente <sup class="required">*</sup></label>
                            <input type="text" class="form-control" id="username" name="username" value="<?php echo $utente->username; ?>" required minlength="1" maxlength="45" />
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="pwd1">Password <sup class="required">*</sup></label>
                                    <input type="password" class="form-control" name="pwd1" id="pwd1" required />
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="pwd2">Conferma password <sup class="required">*</sup></label>
                                    <input type="password" class="form-control" name="pwd2" id="pwd2" required />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="email">Indirizzo e-mail <sup class="required">*</sup></label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $utente->email; ?>" required />
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-group">
                                    <label for="telefono">Numero di telefono <sup class="required">*</sup></label>
                                    <input type="tel" class="form-control" id="telefono" name="telefono" value="<?php echo $utente->telefono; ?>" required />
                                </div>
                            </div>
                        </div>

                    </fieldset>

                    <fieldset>
                        <legend>Completa il tuo profilo</legend>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="provincia">Provincia di residenza</label>
                                    <select name="provincia" id="provincia" class="form-control">

                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="comune">Comune di residenza</label>
                                    <select name="comune" id="comune" class="form-control">
                                    
                                    </select>
                                </div>
                            </div>
                        </div>




                    </fieldset>

                    <fieldset>

                        <div class="form-group">
                            <label for="accetta_tos" class="checkbox"><input type="checkbox" name="accetta_tos" id="accetta_tos" required /> Ho letto e accetto i termini e le condizioni del servizio</label>
                            <br />
                            <label for="accetta_privacy" class="checkbox"><input type="checkbox" name="accetta_privacy" id="accetta_privacy" required /> Ho letto l'informativa sulla privacy e acconsento al trattamento dei miei dati personali</label>
                        </div>

                    </fieldset>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" name="azione" value="conferma">Conferma registrazione</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<?php $contenuto = ob_get_clean(); ?>

<?php
require_once __DIR__ . '/template/index.php';
?>