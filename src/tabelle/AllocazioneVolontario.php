<?php

namespace itcbonelli\donatempo\tabelle;

use DateTime;
use Exception;
use RuntimeException;

class AllocazioneVolontario
{
    public int $id_allocazione;
    public int $id_richiesta;
    public int $id_partecipazione;
    public DateTime $dataora_inizio;
    public DateTime $dataora_fine;

    public function salva()
    {
    }

    public function carica(int $id_allocazione)
    {
    }

    /**
     * Elimina il record corrente
     */
    public function elimina(): bool
    {
        if (empty($this->id_allocazione)) {
            throw new RuntimeException("Il codice allocazione non può essere vuoto");
        }
        global $dbconn;
        $query = "DELETE FROM allocazione_volontario WHERE id_allocazione={$this->id_allocazione}";
        $comando = $dbconn->prepare($query);
        $esegui = $comando->execute();
        return $esegui && $comando->rowCount() > 0;
    }

    public function getRichiesta(): Richiesta
    {
        if (empty($this->id_richiesta)) {
            throw new RuntimeException("Il codice richiesta non può essere vuoto");
        }
        $richiesta = new Richiesta();
        $richiesta->carica($this->id_richiesta);
        return $richiesta;
    }

    public function getPartecipazione(): PartecipazioneAssociazione
    {
        throw new Exception("");
    }
}
