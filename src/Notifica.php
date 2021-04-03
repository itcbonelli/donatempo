<?php

namespace itcbonelli\donatempo;

/**
 * Permette di mostrare un messaggio di notifica all'utente
 * @author Federico Flecchia
 */
class Notifica
{
    /**
     * Coda di notifiche che devono essere mostrate all'utente.
     * @var Notifica[]
     */
    private static $notifiche = [];

    /**
     * Aggiunge una notifica alla coda
     * @param string $testo testo da mostrare all'utente
     * @param string $tipo tipo di notifica
     * @return Notifica la notifica accodata, per eventuali ulteriori notifiche
     */
    public static function accoda($testo, $tipo = self::TIPO_INFORMAZIONE)
    {
        $notifica=new Notifica($testo, $tipo);
        self::$notifiche[] = $notifica;
        $_SESSION['notifiche'] = serialize(self::$notifiche);
        return $notifica;
    }

    /**
     * Mostra le notifiche accodate all'utente e ripulisce la coda
     */
    public static function MostraNotifiche()
    {
        //se avevo delle precedenti notifiche "in canna", le prelevo e le elimino
        if(isset($_SESSION['notifiche'])) {
            $notifiche_precedenti=unserialize($_SESSION['notifiche']);
            array_merge(self::$notifiche, $notifiche_precedenti);
            unset($_SESSION['notifiche']);
        }

        foreach (self::$notifiche as $messaggio) {
            printf("<div class='alert alert-%s'>%s</div>", htmlentities($messaggio->tipo), htmlentities($messaggio->testo));
        }

        //ripulisco la coda di notifiche
        self::$notifiche = [];
    }

    /**
     * Identifica la tipologia del messaggio come di errore (rettangolo rosso)
     */
    public const TIPO_ERRORE = 'danger';

    /**
     * Identifica la tipologia del messaggio come di avvertenza (rettangolo giallo)
     */
    public const TIPO_AVVERTENZA = 'warning';

    /**
     * Identifica la tipologia del messaggio come di informazione (rettangolo azzurro)
     */
    public const TIPO_INFORMAZIONE = 'info';

    /**
     * Identifica la tipologia del messaggio come di successo (rettangolo verde)
     */
    public const TIPO_SUCCESSO = 'success';

    /**
     * Tipologia di messaggio. I valori ammessi sono rappresentati dalle costanti TIPO_ della presente classe
     */
    public string $tipo;

    /**
     * Testo del messaggio da mostrare all'utente
     */
    public string $testo;

    /**
     * Funzione costruttore
     */
    public function __construct(string $testo, string $tipo = self::TIPO_INFORMAZIONE)
    {
        $this->tipo = $tipo;
        $this->testo = $testo;
    }
}
