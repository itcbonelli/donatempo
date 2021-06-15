<?php
require_once __DIR__ . '/include/main.php';
?>
<?php ob_start(); ?>
<div class="section">
    <div class="container">
        <h1>Prenota servizio</h1>
    </div>
</div>



<?php $contenuto = ob_get_clean(); ?>

<?php
require_once __DIR__ . '/template/index.php';
?>