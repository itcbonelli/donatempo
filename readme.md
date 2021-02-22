# AttivaTempo

## Struttura del progetto

* 📂 **api** contiene le chiamate web a supporto della realizzazione dell'app
* 📂 **css** contiene i fogli di stile
* 📂 **docs** contiene i file di documentazione del codice
* 📂 **include** contiene i file di codice che devono essere inclusi
* 📂 **vendor** contiene librerie di terze parti installate tramite il package manager composer.
* **composer.json** è il file di configurazione di composer
* **composer.lock** determina eventuali blocchi di versione delle librerie che composer deve mantenere aggiornate.
* **index.php** è la pagina iniziale

## Installazione

Per installare il portale, eseguire lo script sql collocato nella cartella **sql** per ripristinare il database. Modificare quindi le costanti presenti nel file **include/config.php** in base ai parametri di connessione.