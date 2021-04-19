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

    public function __construct(int $mese = 0, int $anno = -1)
    {
        if ($anno == -1) {
            $this->anno = intval(date('Y'));
        }
        if ($mese < 1 || $mese > 12) {
            $this->mese = intval(date('m'));
        }
    }

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
     * Mostra il calendario mensile nella pagina
     * @author Samuele Ramonda <samuele.ramonda@itcbonelli.edu.it>
     */
    public function calendario()
    {
        $mese = $this->mese;
        $anno = $this->anno;
        switch ($mese) {
            case 1:
                $giorni = 31;
                $giorniMesePrima = 31;
                $nomeMese = "Gennaio";
                break;
            case 3:
                $giorni = 31;
                if ($anno % 4 == 0) {
                    $giorniMesePrima = 29;
                } else {
                    $giorniMesePrima = 28;
                }
                $nomeMese = "Marzo";
                break;
            case 5:
                $giorni = 31;
                $giorniMesePrima = 30;
                $nomeMese = "Maggio";
                break;
            case 7:
                $giorni = 31;
                $giorniMesePrima = 30;
                $nomeMese = "Luglio";
                break;
            case 8:
                $giorni = 31;
                $giorniMesePrima = 31;
                $nomeMese = "Agosto";
                break;
            case 10:
                $giorni = 31;
                $giorniMesePrima = 30;
                $nomeMese = "Ottobre";
                break;
            case 12:
                $giorni = 31;
                $giorniMesePrima = 30;
                $nomeMese = "Dicembre";
                break;
            case 2:
                if ($anno % 4 == 0) {
                    $giorni = 29;
                } else {
                    $giorni = 28;
                }
                $giorniMesePrima = 31;
                $nomeMese = "Febbraio";
                break;
            case 4:
                $giorni = 30;
                $giorniMesePrima = 31;
                $nomeMese = "Aprile";
                break;
            case 6:
                $giorni = 30;
                $giorniMesePrima = 31;
                $nomeMese = "Giugno";
                break;
            case 9:
                $giorni = 30;
                $giorniMesePrima = 31;
                $nomeMese = "Settembre";
                break;
            case 11:
                $giorni = 30;
                $giorniMesePrima = 31;
                $nomeMese = "Novembre";
                break;
        }

        $giornoSettInizioMese = self::giornoData(1, $mese, $anno);
        $giornoSettFineMese = self::giornoData($giorni, $mese, $anno);
        $k = 1;

        if ($mese == 1) {
            $UPmese = $mese + 1;
            $DOWNmese = 12;
            $UPanno = $anno;
            $DOWNanno = $anno - 1;
        } else {
            if ($mese == 12) {
                $UPmese = 1;
                $DOWNmese = $mese - 1;
                $UPanno = $anno + 1;
                $DOWNanno = $anno;
            } else {
                $UPmese = $mese + 1;
                $DOWNmese = $mese - 1;
                $UPanno = $anno;
                $DOWNanno = $anno;
            }
        }

        echo "<table class='calendario table table-bordered'>
        <thead>
            <tr class='bg-danger text-light'> 
                <th class='text-center'><a href='?mese=$DOWNmese&anno=$DOWNanno' class='text-light'><span class='fa fa-arrow-left'></span></a></th>  
                <th class='text-center' colspan=\"5\">$nomeMese $anno</th>  
                <th class='text-center'><a href='?mese=$UPmese&anno=$UPanno' class='text-light'><span class='fa fa-arrow-right'></span></a></th>
            </tr>
            <tr class='text-center'><th>Lun</th><th>Mar</th><th>Mer</th><th>Gio</th><th>Ven</th><th>Sab</th><th>Dom</th></tr>
        </thead>
        <tbody> ";

        echo "<tr>";
        if ($giornoSettInizioMese == 0) {
            $giornoSettInizioMese = 7;
        }
        for ($i = $giornoSettInizioMese - 1; $i > 0; $i--) {
            $giorno = $giorniMesePrima - $i + 1;
            echo "<td class='text-muted'> $giorno </td>";
        }

        $giorno = 0;

        for ($i = 1; $i <= $giorni; $i++) {
        
            $giornoAttuale = self::giornoData($i, $mese, $anno);

            $giorno = $giorno + 1;
            echo "<td> $giorno </td>";

            if ($giornoAttuale == 0) {
                echo "</tr> <tr>";
            }
        }

        if ($giornoAttuale != 0) {
            for ($i = $giornoSettFineMese; $i < 7; $i++) {
                $giorno = $k;
                echo "<td class='text-muted'> $giorno </td>";
                $k++;
            }
            echo "</tr> <tr>";
            for ($i = 0; $i < 7; $i++) {
                $giorno = $k;
                echo "<td class='text-muted'> $giorno </td>";
                $k++;
            }
            echo "</tr>";
        }

        echo "</tbody> </table>";
    }

    public static function giornoData($g, $m, $a)
    {
        $ts = mktime(0, 0, 0, $m, $g, $a);
        $gd = getdate($ts);
        return $gd['wday'];
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
