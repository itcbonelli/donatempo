<?php

namespace itcbonelli\donatempo;

/**
 * Funzioni di supporto per l'output html
 */
class AiutoHTML
{
    /**
     * Mostra le opzioni di un elenco a discesa
     * @param array $dataset elementi con cui popolare l'elenco
     * @param string $displayMember Membro da mostrare a video
     * @param string $valueMember Membro da cui ottenere il valore da memorizzare
     * @param string $selectedValue Valore selezionato
     */
    public static function options(array $dataset, string $valueMember,  string $displayMember, string $selectedValue = "")
    {
        foreach ($dataset as $elemento) {
            $selected = '';
            if (is_array($elemento)) {
                $selected = ($elemento[$valueMember] == $selectedValue) ? 'selected' : '';
                printf("<option value='%s' %s>%s</option>", $elemento[$valueMember], $selected, htmlentities($elemento[$displayMember]));
            } elseif (is_object($elemento)) {
                $selected = ($elemento->$valueMember == $selectedValue) ? 'selected' : '';
                printf("<option value='%s' %s>%s</option>", $elemento->$valueMember, $selected, htmlentities($elemento->$displayMember));
            }
        }
    }

    /**
     * Genera e visualizza un campo di input compatibile con bootstrap
     * @param string $nome nome del campo
     * @param string $etichetta Testo visualizzato nell'etichetta
     * @param string $valore valore da mostrare nel campo
     * @param string $opzioni Altre opzioni del campo
     */
    public static function campoInput($nome, $etichetta, $valore = '', $opzioni = [])
    {
        $opzioni = array_merge([
            'type' => 'text',
            'required' => false,
            'id' => $nome,
            'minlength' => null,
            'maxlength' => null,
            'readonly' => false,
            'helpString' => ''
        ], $opzioni);
?>
        <div class="form-group">
            <label for="<?php echo $opzioni['id']; ?>"><?php echo $etichetta; ?></label>
            <input type="<?php echo $opzioni['type']; ?>" name="<?php echo $nome; ?>" id="<?php echo $opzioni['id']; ?>" value="<?php echo htmlentities($valore); ?>" <?php if ($opzioni['required']) echo 'required="required"'; ?> <?php if (!empty($opzioni['minlength'])) echo "minlength='{$opzioni['minlength']}'"; ?> <?php if (!empty($opzioni['maxlength'])) echo "minlength='{$opzioni['maxlength']}'"; ?> class="form-control" />
            <?php if (!empty($opzioni['helpString'])) echo "<div class='text-muted'>{$opzioni['helpString']}</div>"; ?>
        </div>
    <?php
    }


    /**
     * Genera e visualizza un'area di testo compatibile con bootstrap
     * @param string $nome nome del campo
     * @param string $etichetta Testo visualizzato nell'etichetta
     * @param string $valore valore da mostrare nel campo
     * @param array $opzioni opzioni del campo
     */
    public static function areaTesto($nome, $etichetta, $valore, $opzioni = [])
    {
        $opzioni = array_merge([
            'required' => false,
            'id' => $nome,
            'minlength' => null,
            'maxlength' => null,
            'readonly' => false,
            'helpString' => ''
        ], $opzioni);
    ?>
        <div class="form-group">
            <label for="<?php echo $opzioni['id']; ?>"><?php echo $etichetta; ?></label>
            <textarea name="<?php echo $nome; ?>" id="<?php echo $opzioni['id']; ?>" <?php if ($opzioni['required']) echo 'required="required"'; ?> class="form-control"><?php echo htmlentities($valore); ?></textarea>
            <?php if (!empty($opzioni['helpString'])) echo "<div class='text-muted'>{$opzioni['helpString']}</div>"; ?>
        </div>
    <?php
    }

    public static function checkbox($nome, $etichetta, $valore, $richiesto = false, $id = '')
    {
        if (empty($id)) $id = $nome;
    ?>
        <div class="form-group">
            <label for="<?= $id ?>" class="checkbox">
                <input type="checkbox" name="<?php echo $nome; ?>" <?php if ($richiesto) echo 'required="required"'; ?> id="<?php echo $id; ?>" <?php echo boolval($valore) ? 'checked' : ''; ?> />
                <?php echo $etichetta; ?>
            </label>
        </div>
<?php
    }

    /**
     * Visualizza un bottone per bootstrap
     */
    public static function bsButton($nome, $etichetta, $valore, $tipo='primary') {
        echo "<button class='btn btn-$tipo' name='$nome' value='$valore'>$etichetta</button>";
    }
}
