<?php 
//carico il file principale
require_once __DIR__ . '/include/main.php';

?>
<?php ob_start(); ?>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Registrazione</h1>

                <form action="">
                    
                </form>
            </div>
        </div>
    </div>
<?php $contenuto = ob_get_clean(); ?>

<?php
require_once __DIR__ . '/template/index.php';
?>