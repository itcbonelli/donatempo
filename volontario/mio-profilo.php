<?php
//carico il file principale
require_once __DIR__ . '/../include/main.php';
define('PERCORSO_BASE', '..');
?>
<?php ob_start(); ?>


<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Il mio profilo</h1>

            <form action="" method="post" class="border radius p-2 mb-2 bg-light">
                <fieldset>
                    <legend>Dati anagrafici</legend>
                </fieldset>
            </form>
            <form action="" method="post" class="border radius p-2 mb-2 bg-light">
                <fieldset>
                    <legend>Modifica password</legend>

                    <div class="row">
                    <div class="col">
                            <div class="form-group">
                                <label for="oldpwd">Password attuale</label>
                                <input type="password" name="oldpwd" id="oldpwd" class="form-control" required />
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="pwd1">Password</label>
                                <input type="password" name="pwd1" id="pwd1" class="form-control" required />
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="pwd2">Conferma password</label>
                                <input type="password" name="pwd2" id="pwd2" class="form-control" required />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Modifica password</button>
                    </div>
                </fieldset>
            </form>
            <form action="" method="post" class="border border-radius p-2 bg-light">
                <fieldset>
                    <legend>Elimina il tuo account</legend>

                    <p>Proseguendo con questa operazione sospenderai l'accesso al sito web</p>

                    <div class="form-group">
                        <label for="password">Inserisci la tua password</label>
                        <input type="password" name="password" id="password" class="form-control" required />
                    </div>

                    <button type="submit" class="btn btn-danger">Disattiva il mio account</button>

                </fieldset>
            </form>
        </div>
    </div>
</div>
<?php $contenuto = ob_get_clean(); ?>

<?php
require_once __DIR__ . '/../template/index.php';
?>