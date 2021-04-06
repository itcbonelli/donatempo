<?php

use itcbonelli\donatempo\Notifica;

define('PERCORSO_BASE', '..');
require_once __DIR__ . '/../include/main.php';


?>
<?php ob_start(); ?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Diventa volontario</h1>
            <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Est, consectetur corporis, illum eos rerum vel obcaecati quas minus nam amet alias vero consequatur voluptate magni sapiente aliquid eius necessitatibus assumenda?</p>
        </div>
    </div>
</div>
<?php $contenuto = ob_get_clean(); ?>

<?php
require_once __DIR__ . '/../template/index.php';
?>