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
                $selected = $elemento[$valueMember] == $selectedValue ? 'selected' : '';
                printf("<option value='%s' %s>%s</option>", $elemento[$valueMember], $selected, $elemento[$displayMember]);
            } elseif (is_object($elemento)) {
                $selected = $elemento->$valueMember == $selectedValue ? 'selected' : '';
                printf("<option value='%s'>%s</option>", $elemento->$valueMember, $elemento->$displayMember);
            }
        }
    }
}
