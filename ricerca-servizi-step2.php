<?php
//carico il file principale

use itcbonelli\donatempo\tabelle\Servizio;

require_once __DIR__ . '/include/main.php';

$servizi = Servizio::elencoServizi(true);

?>
<?php ob_start(); ?>


<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-3">
                <form action="" method="post">
                    
                </form>
            </div>
            <div class="col-9">
                <form action="">

                </form>
            </div>
        </div>
    </div>
</div>



<?php $contenuto = ob_get_clean(); ?>

<?php
require_once __DIR__ . '/template/index.php';
?>