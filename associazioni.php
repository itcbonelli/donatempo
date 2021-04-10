<?php
//carico il file principale
require_once __DIR__ . '/include/main.php';

?>
<?php ob_start(); ?>

<div class="container">
    <div class="row">

        <div class="col-12">
            <h1>Associazioni</h1>

            <div class="card-deck">

                <div class="card" style="max-width: 320px;">
                    <img class="card-img-top" src="holder.js/100x180/" alt="">
                    <div class="card-body">
                        <h4 class="card-title">Nome associazione</h4>
                        <p class="card-text">Lorem ipsum dolor sit amet consectetur</p>
                        <p><a href="associazione.php?id=" class="btn btn-outline-primary">Vedi dettagli</a></p>
                    </div>
                    
                </div>

            </div>
        </div>
    </div>
</div>
<?php $contenuto = ob_get_clean(); ?>

<?php
require_once __DIR__ . '/template/index.php';
?>