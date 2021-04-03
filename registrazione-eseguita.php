<?php
//carico il file principale

use itcbonelli\donatempo\AiutoInput;
use itcbonelli\donatempo\Notifica;
use itcbonelli\donatempo\tabelle\Utente;

require_once __DIR__ . '/include/main.php';

$utente = new Utente();
if ($_POST) {
    $utente->username = AiutoInput::leggiStringa('username');

    $pwd1 = AiutoInput::leggiStringa('pwd1');
    $pwd2 = AiutoInput::leggiStringa('pwd2');
    if ($pwd1 == $pwd2) {
        $utente->password = $pwd1;
    } else {
        Notifica::accoda("Le password inserite non coincidono", Notifica::TIPO_ERRORE);
    }
}

?>
<?php ob_start(); ?>
<div class="container">
    <div class="row">
        <div class="col-12">
        
            <div class="text-center mt-4"><i class="fa fa-check-circle fa-4x text-success" aria-hidden="true"></i></p>
            <h1 class="text-center"> Registrazione eseguita con successo</h1>

            <p class="lead text-center">Ti abbiamo inviato una mail di promemoria con i tuoi dati di registrazione.</p>

            <p class="text-center"><a href="accesso.php"><i class="fa fa-arrow-left" aria-hidden="true"></i> Vai alla pagina di accesso</a></p>


            <?php Notifica::MostraNotifiche(); ?>
            
        </div>
    </div>
</div>
<?php $contenuto = ob_get_clean(); ?>

<?php
require_once __DIR__ . '/template/index.php';
?>