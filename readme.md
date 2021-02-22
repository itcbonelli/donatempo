# DONATEMPO

## Struttura del progetto

* 📂 **api** contiene le chiamate web a supporto della realizzazione dell'app
* 📂 **css** contiene i fogli di stile
* 📂 **docs** contiene i file di documentazione del codice
* 📂 **icon** contiene i file di icona per i dispositivi mobili
* 📂 **img** contiene le immagini
* 📂 **include** contiene i file di codice che devono essere inclusi
    * 📂 **tabelle** classi di gestione delle tabelle
    * 📂 **template** parti comuni di pagine web da includere
    * **config.php** file di configurazione. Le costanti relative alla configurazione del sito sono presenti in questo file, non modificare gli altri file.
    * **connessione.php** file di connessione al database
    * **funzioni.php** funzioni richiamabili nelle varie pagine.
* 📂 **uploads** ospiterà i file caricati dagli utenti durante l'esercizio del sistema
* 📂 **vendor** contiene librerie di terze parti installate tramite il package manager composer.
* **accesso.php** pagina di login
* **composer.json** è il file di configurazione di composer
* **composer.lock** determina eventuali blocchi di versione delle librerie che composer deve mantenere aggiornate.
* **index.php** è la pagina iniziale
* **recupero-password.php** pagina di recupero della password
* **registrazione.php** pagina di registrazione
* **ricerca.php** pagina di ricerca

## Installazione

Per installare il portale, eseguire lo script sql collocato nella cartella **sql** per ripristinare il database. Modificare quindi le costanti presenti nel file **include/config.php** in base ai parametri di connessione.