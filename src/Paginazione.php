<?php

namespace itcbonelli\donatempo;

/**
 * Permette di gestire la suddivisione di grandi dataset su più pagine
 */
class Paginazione
{
    /**
     * Numero di record da mostrare in una pagina
     */
    public int $limite = 24;

    /**
     * Numero di record da saltare
     */
    public int $offset = 0;

    /**
     * Conteggio totale dei record restituiti dalla query
     */
    public int $contaRecord;

    /**
     * Costruttore
     */
    public function __construct($contaRecord = 0)
    {
        $this->contaRecord = $contaRecord;
        $this->offset = AiutoInput::leggiIntero('pageskip', 0, 'GP');
    }

    /**
     * Ottiene il numero totale di pagine da mostrare
     */
    public function getNumeroPagine(): int
    {
        return ceil($this->contaRecord / $this->limite);
    }

    /**
     * Ottiene l'indice della pagina attiva
     */
    public function getPaginaAttiva()
    {
        return floor($this->offset / $this->limite);
    }

    

    /**
     * Mostra i controlli di paginazione nella pagina web
     */
    public function mostraPaginazione()
    {
?>
        <nav aria-label="Navigazione tra le pagine">
            <ul class="pagination">
                <li class="page-item disabled">
                    <a class="page-link" href="#" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only">Precedente</span>
                    </a>
                </li>
                <?php
                $np = $this->getNumeroPagine();
                $pa = $this->getPaginaAttiva();

                $n = 10;
                $sx = $pa;
                $dx = $pa;

                while ($n > 0 && $n<$np) {
                    if($sx>0) {
                        $sx--;
                        $n--;
                    }
                    if($dx<$np) {
                        $dx++;
                        $n--;
                    }
                }

                for ($i = $sx; $i <= $dx; $i++) : ?>
                    <li class="page-item <?= $i == $pa ? 'active' : ''; ?>">
                        <a class="page-link" href="?pageskip=<?= $i * $this->limite; ?>"><?= $i+1; ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item">
                    <a class="page-link" href="#" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">Successiva</span>
                    </a>
                </li>
            </ul>
        </nav>
<?php
    }

    /**
     * Ottiene la clausola limit da accodare alla query SQL.
     * @return string
     */
    public function getLimit(): string {
        return sprintf("LIMIT %d OFFSET %d", $this->limite, $this->offset);
    }
}
