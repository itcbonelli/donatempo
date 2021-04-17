<?php

namespace itcbonelli\donatempo\calendario;

use Appuntamento;
use DateTime;

class Calendario
{
    /**
     * Mese selezionato
     */
    public int $mese;

    /**
     * Anno selezionato
     */
    public int $anno;

    /**
     * Elenco degli appuntamenti previsti
     * @var Appuntamento[]
     */
    public array $appuntamenti;

    /**
     * Mostra a video gli appuntamenti in una particolare data
     */
    public function getAppuntamentiPerData(DateTime $data)
    {
        $appu = [];
        foreach ($this->appuntamenti as $appuntamento) {
            if ($appuntamento->data) {
            }
        }

        return $appu;
    }

    /**
     * Mostra il calendario nella pagina web
     */
    public function render(string $id = "")
    {
?>
        <table id="<?= $id; ?>" class="calendario table table-bordered table-sm">
            <thead>
                <tr class="bg-danger text-light">
                    <th colspan="7" class="text-center">
                        <button class="btn btn-sm btn-light border"><i class="fa fa-arrow-left" aria-hidden="true"></i><span class="sr-only">Mese precedente</span></button>
                        <?php
                        echo _(date('F'));
                        ?>
                        <button class="btn btn-sm btn-light border"><i class="fa fa-arrow-right" aria-hidden="true"></i><span class="sr-only">Mese successivo</span></button>
                    </th>
                </tr>
                <tr>
                    <th class="text-center">Lun</th>
                    <th class="text-center">Mar</th>
                    <th class="text-center">Mer</th>
                    <th class="text-center">Gio</th>
                    <th class="text-center">Ven</th>
                    <th class="text-center">Sab</th>
                    <th class="text-center text-danger">Dom</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php for ($i = 1; $i <= 42; $i++) : ?>
                        <td>&nbsp;</td>
                        <?php if ($i % 7 == 0) {
                            echo '</tr><tr>';
                        } ?>
                    <?php endfor; ?>
                </tr>
            </tbody>
        </table>
<?php
    }
}
