<?php

namespace itcbonelli\donatempo\tabelle;

use DateTime;
use Exception;

class AllocazioneVolontario {
    public int $id_allocazione;
    public int $id_richiesta;
    public int $id_partecipazione;
    public DateTime $dataora_inizio;
    public DateTime $dataora_fine;

    public function salva() {

    }

    public function carica(int $id_allocazione) {

    }

    public function elimina() {

    }

    public function getRichiesta(): Richiesta {
        throw new Exception("");
    }

    public function getPartecipazione() : PartecipazioneAssociazione {
        throw new Exception("");
    }
}