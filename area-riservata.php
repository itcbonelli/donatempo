<?php
//carico il file principale
require_once __DIR__ . '/include/main.php';

?>
<?php ob_start(); ?>

<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center font-weight-light">Area riservata</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">

            </div>
        </div>
    </div>
</div>
<?php $contenuto = ob_get_clean(); ?>

<?php
require_once __DIR__ . '/template/index.php';
?>