# API Donatempo

Le API di Donatempo permettono di interfacciare il progetto con applicazioni mobili o con altri sistemi tramite richieste HTTP.

Il pattern di sviluppo adottato è il "Front Controller": tutte le richieste in ingresso sono redirezionate (tramite le regole di riscrittura contenute nel file htaccess) alla pagina index.php.

Questa si occupa quindi di leggere i parametri get e di redirezionare la richiesta al modulo corrispondente (altri file php).

Ogni richiesta ha quindi il seguente URL di base:

```
https://donatempo.it/api/modulo/funzione?parametri=...
```


# Moduli e funzioni

* associazioni
    * elencoAssociazioni : carica l'elenco di tutte le associazioni attive.
    * getAssociazione: carica il record di una singola associazione
        * Parametri
            * id (int) identificativo associazione
        * Output: record associazione in formato JSON
    * putAssociazione: salva il record di una singola associazione