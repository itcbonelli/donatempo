<?php

namespace itcbonelli\donatempo\calendario;

use Appuntamento;
use DateTime;

/**
 * Fornisce metodi per la generazione e la gestione del calendario di appuntamenti
 */
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
    public array $appuntamenti = [];

    public function __construct(int $mese = 0, int $anno = -1)
    {
        if ($anno == -1) {
            $this->anno = intval(date('Y'));
        } else {
            $this->anno = $anno;
        }
        if ($mese < 1 || $mese > 12) {
            $this->mese = intval(date('m'));
        } else {
            $this->mese = $mese;
        }
    }

    /**
     * Ottiene gli appuntamenti in una particolare data
     * @return Appuntamento[]
     */
    public function getAppuntamentiPerData(DateTime $data)
    {
        $appu = [];
        foreach ($this->appuntamenti as $appuntamento) {
            if ($appuntamento->data == $data) {
                $appu[] = $appuntamento;
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

        echo "<table class='calendario table table-bordered' style='table-layout:fixed'>
        <thead>
            <tr class='bg-danger text-light'> 
                <th class='text-center'><a href='?mese=$DOWNmese&anno=$DOWNanno' class='btn btn-light' title='Vai al mese precedente'><span class='fa fa-arrow-left'></span></a></th>  
                <th class='text-center' colspan=\"5\" style='vertical-align:middle; font-size: 24px'>$nomeMese $anno</th>  
                <th class='text-center'><a href='?mese=$UPmese&anno=$UPanno' class='btn btn-light' title='Vai al mese successivo'><span class='fa fa-arrow-right'></span></a></th>
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

            $appuntamenti = $this->getAppuntamentiPerData(DateTime::createFromFormat('Y-m-d', "$anno-$mese-$giorno"));

            echo "<td>";
            echo "<span class='badge badge-light'>$giorno</span><br />";
            foreach($appuntamenti as $appu) {
                if(strlen($appu->link)>0) {
                    echo "<a href=\"$appu->link\">";
                }
                printf("<span class='badge badge-primary'>%s - %s-%s</span>", $appu->descrizione, $appu->ora_inizio->format('H:i'), $appu->ora_fine->format('H:i'));
                if(strlen($appu->link)>0) {
                    echo "</a>";
                }
            }
            echo "</td>";

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

    /**
     * Ottiene il giorno della settimana a partire da una data
     * @param int $g giorno
     * @param int $m mese
     * @param int $a anno
     * 
     * @author Samuele Ramonda <samuele.ramonda@itcbonelli.edu.it>
     */
    public static function giornoData(int $g, int $m, int $a)
    {
        $ts = mktime(0, 0, 0, $m, $g, $a);
        $gd = getdate($ts);
        return $gd['wday'];
    }
}
