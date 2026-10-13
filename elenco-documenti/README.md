# Elenco Documenti per Siti Scolastici

Pagina web leggera che mostra in elenco i documenti (PDF, Word, Excel) presenti sul server di un sito scolastico, organizzati per cartella, con ricerca e download diretto.

## Funzionalità

- Scansione automatica della cartella principale e di tutte le sottocartelle
- Ordinamento per data: i documenti più recenti compaiono per primi
- Evidenziazione dei file aggiunti negli ultimi 3 giorni
- Barra di ricerca per nome file o nome cartella
- Pulsante di download per ogni documento
- Dimensione e data di ultima modifica visibili in tabella
- Integrabile in una pagina esistente tramite `iframe`

## Requisiti

- Server web con **PHP 7.4** o superiore
- Connessione a internet per le icone (Bootstrap Icons, caricate da CDN)
- Accesso al server via FTP, SFTP o pannello di controllo

## Struttura del progetto
elenco-documenti/
├── index.html # Interfaccia della pagina
├── get_documents.php # Script che legge i file e restituisce i dati in JSON
└── esempio-iframe.html # Esempio di come inserire la pagina in un altro sito


## Installazione

1. Carica `index.html` e `get_documents.php` nella stessa cartella del server, per esempio `/documenti/`.
2. Crea nella stessa cartella le sottocartelle che vuoi mostrare, per esempio `modulistica/`, `circolari/`, `progetti/`.
3. Inserisci i file nelle cartelle corrispondenti..
5. Apri `https://tuosito.it/documenti/` nel browser per verificare che l'elenco venga visualizzato.

Non serve nessuna configurazione: lo script legge direttamente le cartelle.

## Come si aggiungono i documenti

Basta copiare il file nella cartella giusta. Non è necessario modificare il codice. Il file compare nell'elenco al successivo caricamento della pagina.

## Inserimento in un'altra pagina del sito web

Per mostrare l'elenco dentro una pagina esistente, apri in modalità codice html e usa un `iframe`:

```html
<iframe width="100%"
        height="600px"
        style="border: none; display: block; clear: both;"
        src="https://www.esempio.edu.it/cartelladocumenti/"
        allowfullscreen="allowfullscreen"
        sandbox="allow-scripts allow-same-origin allow-downloads">
</iframe>

```

Regola `height` in base alla quantità di contenuto e ovviamente il campo src che punti alla cartella del server.
L'attributo sandbox  è consigliato per evitare lo spiacevole errore di cookies

## Personalizzazione

- **Cartelle da escludere:** in `get_documents.php` modifica l'array `$escluse` con i nomi delle cartelle da non mostrare.
- **Giorni per l'evidenziazione "Nuovo":** in `index.html` modifica la costante `TRE_GIORNI_IN_SECONDI`.
- **Estensioni supportate:** in `get_documents.php` modifica il pattern `*.{pdf,doc,docx,xls,xlsx}`.
- **Colori:** le variabili CSS sono all'inizio del tag `<style>` in `index.html`.

## Sicurezza

- La pagina elenca tutti i file presenti nelle cartelle. Non inserire in queste cartelle documenti riservati o con dati personali.
- Il servizio mostra solo i file con le estensioni indicate e non espone il contenuto dello script PHP.
- Le impostazioni CORS sono aperte (`Access-Control-Allow-Origin: *`). Limitale al dominio della scuola se il sito è pubblico.

## Limiti noti

- I nomi dei file con caratteri speciali vanno verificati dopo l'installazione.
- Non c'è paginazione: con molti file la pagina può diventare lunga.
- La scansione avviene a ogni caricamento della pagina.

## Licenza

Distribuito con licenza MIT. Vedi il file [LICENSE](LICENSE).

## Avvertenze

Il progetto non è affiliato a Gruppo Spaggiari né a nessun fornitore di registro elettronico o sito scolastico. Prima di installarlo su un sito istituzionale, verifica con il tuo referente tecnico e con la dirigenza che sia consentito.

## Contributi

Segnalazioni di bug e proposte di miglioramento sono benvenute tramite le *Issue* di GitHub.
