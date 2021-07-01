<?php

use itcbonelli\donatempo\Notifica;

define('PERCORSO_BASE', '..');
require_once __DIR__ . '/../include/main.php';


?>
<?php ob_start(); ?>

<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Dona il tuo tempo a chi ha bisogno di una mano</h1>
                <p>
                    A volte per aiutare una persona che si sta trovando in difficoltà
                    basta un gesto semplice, come donare un'ora del proprio tempo per dare una mano con le piccole commissioni di ogni giorno,
                    oppure fare compagnia alleviando il peso della solitudine.
                </p>
                <p>Iniziare a collaborare con DONATEMPO è semplicissimo:</p>
                <ol>
                    <li>Se non l'hai ancora fatto, <a href="../registrazione.php"><strong>registrati ora</strong></a></li>
                    <li>Accedi alla pagina <a href="mie-associazioni.php"><strong>le mie associazioni</strong></a> per richiedere l'iscrizione ad un'associazione come volontario</li>
                    <li>Sarai ricontattato dall'associazione per perfezionare la tua iscrizione e, una volta approvata, potrai iniziare a ricevere ed esaudire richieste di aiuto</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<?php $contenuto = ob_get_clean(); ?>

<?php
require_once __DIR__ . '/../template/index.php';
?>