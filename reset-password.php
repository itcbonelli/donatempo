<?php
require_once __DIR__ . '/include/main.php';
?>
<?php ob_start(); ?>

<div class="container">
    <h1>Accesso</h1>

    <form action="" method="post">
        
        <div class="form-group">
            <label for="password">Nuova password</label>
            <input type="password" class="form-control" name="password" id="password" required />
        </div>
        <div class="form-group">
            <label for="password2">Conferma password</label>
            <input type="password" class="form-control" name="password2" id="password2" required />
        </div>
        <button type="submit" class="btn btn-primary" id="cmd_conferma">Reimposta password</button>
        <span class="badge badge-danger" hidden id="badge_nonuguali">Le password inserite non coincidono</span>
    </form>

</div>
<script>
    var pwd1=document.getElementById('password');
    var pwd2=document.getElementById('password2');
    var cmd_conferma = document.getElementById('cmd_conferma');
    var badge_nonuguali = document.getElementById('badge_nonuguali');

    function controllo_password() {
        badge_nonuguali.hidden=true;
        if(pwd1.value.length>0 && pwd2.value.length>0) {
            if(pwd1.value==pwd2.value) {
                cmd_conferma.disabled=false;
            } else {
                cmd_conferma.disabled=true;
                badge_nonuguali.hidden=false;
            }
        } else {
            cmd_conferma.disabled=true;
        }
    }

    controllo_password();
    pwd1.addEventListener('keyup', controllo_password);
    pwd1.addEventListener('change', controllo_password);
    pwd2.addEventListener('keyup', controllo_password);
    pwd2.addEventListener('change', controllo_password);
    
</script>

<?php $contenuto = ob_get_clean(); ?>
<?php
require_once __DIR__ . '/template/index.php';
?>