# php-cbi-parser Library

**Descrizione:**
Questa libreria PHP, denominata php-cbi-parser, è un progetto sviluppato per parsare, validare ed estrarre dati strutturati dai file di interscambio di Corporate Banking Interbancario (CBI). Fornisce strumenti e moduli per lo sviluppo di applicazioni basate su PHP, utilizzando Composer per la gestione delle dipendenze. Il progetto include documentazione, codice sorgente e risorse per facilitare l'integrazione e l'uso.

**Installazione:**
Per installare la libreria, utilizza Composer. Esegui il seguente comando nella directory del tuo progetto:

```
composer require blacksoulgem95/php-cbi-parser
```

Assicurati di avere Composer installato. Una volta installata, puoi includere la libreria nei tuoi file PHP.

**Struttura del Progetto:**
- **src/**: Contiene il codice sorgente principale della libreria, con CBILib.php come entry point principale, inclusi file PHP con le classi e le funzioni core.
- **vendor/**: Gestito da Composer, include le dipendenze esterne.
- **CBI-docs/**: Cartella per la documentazione aggiuntiva, come guide e esempi.
- **composer.json e composer.lock**: File di configurazione per le dipendenze e la versione del progetto.

**Uso:**
Per utilizzare la libreria, includi i file necessari nel tuo codice. Ecco un esempio semplice:

```php
require_once 'vendor/autoload.php';

use Blacksoulgem95\CbiLib\CBILib;

$cbiLib = new CBILib();
$cbiLib->processCBIFile('/path/to/your/file.cbi');
```

Assicurati di consultare la documentazione in CBI-docs per dettagli più specifici.

**Contributi:**
Se desideri contribuire, forked il repository, crea una branch e invia una pull request. Per qualsiasi domanda, contatta blacksoulgem95.
