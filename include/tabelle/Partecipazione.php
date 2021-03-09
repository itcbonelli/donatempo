<?php

/**
 * Record di associazione tra utente e associazione di volontariato
 */
class PartecipazioneAssociazione
{
    /**
     * Valore del campo ruolo per il volontario
     */
    const RUOLO_VOLONTARIO = 'volontario';

    /**
     * Valore del campo ruolo per l'amministratore
     */
    const RUOLO_AMMINISTRATORE = 'amministratore';

    /**
     * Identificativo utente partecipante
     * @var int
     */
    public $idUtente;

    /**
     * Identificativo associazione
     * @var int
     */
    public $idAssociazione;

    /**
     * Ruolo ricoperto nell'associazione
     * @var string
     */
    public $ruolo;

    /**
     * Ottiene le partecipazioni ad associazioni di un dato utente
     * @param int $id_utente identificativo utente
     * @return PartecipazioneAssociazione[] array di record partecipazione
     */
    public static function getPartecipazioniUtente($id_utente)
    {
        global $dbconn;

        $partecipazioneAssociazione=[];

        $query="SELECT * FROM utente_partecipa_associazione";
        if($id_utente != null){
            $query .= " WHERE utenti_id_utente= $id_utente";
        }
        $query .= " ORDER BY associazioni_id_associazione";

        $comando = $dbconn->prepare($query);
        $esegui = $comando->execute();

        if ($esegui == true) {
            while ($riga = $comando->fetch()) {
                $partecipa = new PartecipazioneAssociazione();
                $partecipa->idUtente = $riga['utenti_id_utente'];
                $partecipa->idAssociazione = $riga['associazioni_id_associazione'];
                $partecipa->ruolo = $riga['ruolo'];
                $partecipazioneAssociazione[] = $partecipa;
            }
        }
        return $partecipazioneAssociazione;
    }

    

    /**
     * Ottiene le partecipazioni ad associazioni degli utenti assegnati ad una data associazione
     * @param int $id_utente identificativo utente
     * @return PartecipazioneAssociazione[] array di record partecipazione
     */
    public static function getPartecipantiAssociazione($id_associazione)
    {
    }

    /**
     * Salva il record nel database
     * @return bool esito operazione
     */
    public function salva()
    {
        global $dbconn;
        throw new Exception("Non ancora implementato");
    }

    /**
     * Elimina il record nel database
     * @return bool esito operazione
     */
    public function elimina()
    {
        global $dbconn;
        throw new Exception("Non ancora implementato");
    }
}
