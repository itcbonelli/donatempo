<?php
//carico il file principale

use itcbonelli\donatempo\tabelle\Associazione;

require_once __DIR__ . '/include/main.php';

$voce_attiva='associazioni';

$associazioni = Associazione::elencoAssociazioni();

?>
<?php ob_start(); ?>

<div class="container">
    <div class="row">

        <div class="col-12">
            <h1>Associazioni</h1>

            <div class="card-deck">
                <?php foreach ($associazioni as $associazione) :
                    $settori = $associazione->getSettori();

                ?>
                    <div class="card" style="min-width: 256px; max-width: 320px;">
                        <img class="card-img-top" src="uploads/loghi-associazioni/<?= $associazione->url_logo ?>" alt="">
                        <div class="card-body">
                            <h4 class="card-title"><?php echo $associazione->ragsoc; ?></h4>
                            <p class="card-text">
                                <?php foreach ($settori as $settore) {
                                    echo "<span class='badge badge-light border'>{$settore->nome}</span>";
                                } ?></p>
                            <p><a href="associazione.php?id=<?= $associazione->id_associazione ?>" class="btn btn-outline-primary">Vedi dettagli</a></p>
                        </div>

                    </div>
                <?php endforeach; ?>

            </div>
        </div>
    </div>
</div>
<?php $contenuto = ob_get_clean(); ?>

<?php
require_once __DIR__ . '/template/index.php';
?>