<?php
//alcuni file sono caricati con url relativo.
//ho bisogno di una costante che mi permetta di raggiungere il percorso base del sito.
//se tale costante non è definita, la definisco assumendo che il file si trovi nella web root.
if (!defined('PERCORSO_BASE')) {
    define('PERCORSO_BASE', '.');
}
?>
<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'DONATEMPO'; ?></title>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Icone -->
    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo PERCORSO_BASE; ?>/icon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo PERCORSO_BASE; ?>/icon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo PERCORSO_BASE; ?>/icon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo PERCORSO_BASE; ?>/icon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo PERCORSO_BASE; ?>/icon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo PERCORSO_BASE; ?>/icon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo PERCORSO_BASE; ?>/icon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo PERCORSO_BASE; ?>/icon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo PERCORSO_BASE; ?>/icon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="<?php echo PERCORSO_BASE; ?>/icon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo PERCORSO_BASE; ?>/icon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo PERCORSO_BASE; ?>/icon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo PERCORSO_BASE; ?>/icon/favicon-16x16.png">
    <link rel="manifest" href="<?php echo PERCORSO_BASE; ?>/icon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?php echo PERCORSO_BASE; ?>/icon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css" integrity="sha512-yVvxUQV0QESBt1SyZbNJMAwyKvFTLMyXSyBHDO4BG5t7k/Lw34tyqlSDlKIrIENIzCl+RVUNjmCPG+V/GMesRw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?php echo PERCORSO_BASE; ?>/css/style.css" />
</head>

<body>
    <header class="donatempo-header">
        <?php require __DIR__ . '/navigazione.php'; ?>
    </header>

    <?php if (isset($contenuto)) echo $contenuto; ?>

    <footer>
        <div class="container">
            <hr />

            <p class="text-center social-icons">
                <a href="#"><i class="fa fa-facebook-official fa-2x text-dark" aria-hidden="true"></i></a>
                <a href="#"><i class="fa fa-twitter fa-2x text-dark" aria-hidden="true"></i></a>
                <a href="#"><i class="fa fa-instagram fa-2x text-dark" aria-hidden="true"></i></a>
                <a href="#"><i class="fa fa-envelope fa-2x text-dark" aria-hidden="true"></i></a>
            </p>
            <p class="text-center">Copyright &copy; <?php echo date('Y') ?>. Tutti i diritti riservati.<br />
                <span style="font-size: 11px;">
                    Applicazione realizzata dai ragazzi della classe 5^A SIA dell'ITC F.A. Bonelli. <a href="credits.php">Credits</a>
                </span>
            </p>

        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js" integrity="sha512-rMGGF4wg1R73ehtnxXBt5mbUfN9JUJwbk21KMlnLZDJh7BkPmeovBuddZCENJddHYYMkCh9hPFnPmS9sspki8g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(".chzn-select").chosen();
    </script>
</body>

</html>