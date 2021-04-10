<?php
//carico il file principale
require_once __DIR__ . '/include/main.php';

?>
<?php ob_start(); ?>

<div class="container">
    <div class="row">

        <div class="col-4">
            <img src="" alt="Logo associazione" />
            <h1>{nome associazione}</h1>
        </div>
        <div class="col-8">
        
        </div>
    </div>
</div>
<?php $contenuto = ob_get_clean(); ?>

<?php
require_once __DIR__ . '/template/index.php';
?>