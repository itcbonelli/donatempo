# DONATEMPO

Progetto realizzato dagli alunni della classe V A SIA e dai docenti di informatica proff. Flecchia Federico e Console Laura in collaborazione con il capitolato La Granda del gruppo BNI e con l'associazione Casa Do Menor.

Donatempo è un'app che permette di mettere in contatto le associazioni di volontariato e i loro volontari con persone bisognose. Questo progetto fornisce la base di dati, il backoffice di gestione e le api per l'accesso ai dati come servizi web.

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
* 📂 **src** Contiene il codice sorgente delle classi caricate attraverso il sistema di autoloading
* 📂 **vendor** contiene librerie di terze parti installate tramite il package manager composer.
* **accesso.php** pagina di login
* **composer.json** è il file di configurazione di composer
* **composer.lock** determina eventuali blocchi di versione delle librerie che composer deve mantenere aggiornate.
* **index.php** è la pagina iniziale
* **recupero-password.php** pagina di recupero della password
* **registrazione.php** pagina di registrazione
* **ricerca.php** pagina di ricerca

## Installazione

### Requisiti di sistema
Donatempo richiede PHP 7.4 o versione superiore in quanto fa uso degli attributi di classe fortemente tipizzati. La versione del database su cui è stato sviluppato e testato è MariaDB 10.
E' inoltre consigliabile attivare l'estensione *opcache* al fine di ottenere un significativo miglioramento delle prestazioni.

### Procedura
Per installare il portale, eseguire lo script sql collocato nella cartella **sql** per ripristinare il database. Modificare quindi le costanti presenti nel file **include/config.php** in base ai parametri di connessione.

## Librerie di terze parti

Il progetto, nato in un contesto scolastico, ambisce a ridurre al minimo il ricorso a librerie di terze parti. Si indicano di seguito quelle utilizzate.

* **PHPMailer**: fornisce classi per l'invio di messaggi di posta elettronica. Rispetto alla semplice funzione mail() di PHP permette l'utilizzo di server SMTP personalizzati e di gestire più facilmente le intestazioni del messaggio.
* **Chosen** Chosen è una libreria JavaScript che permette di trasformare le combo-box (select) attivando la ricerca. Viene utilizzata per la scelta degli oltre 8000 comuni italiani presenti.

## Definizione del database

Il file **[docs/dizionario-dati-donatempo.pdf](docs/dizionario-dati-donatempo.pdf)** contiene la definizione dettagliata di tabelle, campi e indici, comprensiva di commenti.

E' inoltre disponibile il modello e-r all'URL **[docs/modello-er.pdf](docs/modello-er.pdf)**.