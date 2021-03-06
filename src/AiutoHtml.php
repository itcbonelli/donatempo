<?php

namespace itcbonelli\donatempo;

use itcbonelli\donatempo\tabelle\Comune;
use itcbonelli\donatempo\tabelle\Provincia;

/**
 * Funzioni di supporto per l'output html
 */
class AiutoHTML
{
    /**
     * Mostra l'elenco dei comuni in un elenco a discesa
     * @param string $selezionato Codice comune selezionato
     */
    public static function optionsComuni(?string $selezionato = "")
    {
        $province = Provincia::caricaTutte();
        foreach ($province as $prov) {
            printf("<optgroup data-provincia=\"%s\" label=\"%s\">", $prov->sigla, $prov->denominazione);
            $comuni = Comune::getElencoComuni($prov->sigla);
            foreach ($comuni as $comune) {
                $selected = '';
                $selected = ($comune->id_comune == $selezionato) ? 'selected' : '';
                printf("<option value='%s' %s data-provincia='%s'>%s</option>", $comune->id_comune, $selected, $comune->provincia, htmlentities($comune->denominazione));
            }
            echo "</optgroup>";
        }
    }

    /**
     * Mostra le opzioni di un elenco a discesa
     * @param array $dataset elementi con cui popolare l'elenco
     * @param string $displayMember Membro da mostrare a video
     * @param string $valueMember Membro da cui ottenere il valore da memorizzare
     * @param string $selectedValue Valore selezionato
     */
    public static function options(array $dataset, string $valueMember,  string $displayMember, ?string $selectedValue = "")
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
            'minlength' => 0,
            'maxlength' => 524288,
            'readonly' => false,
            'disabled' => false,
            'helpString' => ''
        ], $opzioni);
?>
        <div class="form-group">
            <label for="<?= $opzioni['id']; ?>"><?= $etichetta; ?></label>
            <input type="<?= $opzioni['type']; ?>" name="<?= $nome; ?>" 
                id="<?= $opzioni['id']; ?>" value="<?= htmlentities($valore); ?>" 
                <?= ($opzioni['required']) ? ' required ' : ''; ?> <?= ($opzioni['disabled']) ? ' disabled ' : ''; ?> 
                minlength="<?= $opzioni['minlength']; ?>" 
                maxlength="<?= $opzioni['maxlength']; ?>" 
                class="form-control" />
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
    public static function bsButton($nome, $etichetta, $valore, $type = 'submit', $aspetto = 'primary')
    {
        echo "<button type='{$type}' class='btn btn-$aspetto' name='$nome' value='$valore'>$etichetta</button>";
    }


    /**
     * Mostra in maniera visuale un valore booleano
     */
    public static function yesNo($valore)
    {
        if (boolval($valore)) {
            echo "<span class='fa fa-check' style='color: forestgreen'></span>";
        } else {
            echo "<span class='fa fa-times' style='color: darkred'></span>";
        }
    }
}
