<?php
/**
* Zen Cart German Specific
* @copyright Copyright 2003-2025 Zen Cart Development Team
* Zen Cart German Version - www.zen-cart-pro.at
* @copyright Portions Copyright 2003 osCommerce
* @license https://www.zen-cart-pro.at/license/3_0.txt GNU General Public License V3.0
* @version $Id: paypalr.php 2025-11-16 10:00:24Z webchills $
*/

define('MODULE_PAYMENT_PAYPALR_TEXT_TITLE', 'PayPal Checkout');
define('MODULE_PAYMENT_PAYPALR_SUBTITLE', '<br>Utilizza il tuo <b>conto PayPal</b> (clicca su PayPal Wallet) <b>oppure</b> una <b>carta di credito</b> (clicca su Carta di credito)');
define('MODULE_PAYMENT_PAYPALR_TEXT_TITLE_ADMIN', 'PayPal Checkout (RESTful)');
define('MODULE_PAYMENT_PAYPALR_TEXT_DESCRIPTION', '<strong>PayPal</strong>');
define('MODULE_PAYMENT_PAYPALR_TEXT_TYPE', 'PayPal Checkout');

// -----
// Konfigurationsbezogene Fehler, die während der Administratorkonfiguration des Zahlungsmoduls angezeigt werden.
//
define('MODULE_PAYMENT_PAYPALR_ERROR_NO_CURL', 'CURL ist nicht installiert, dieses Modul kann daher nicht verwendet werden.');
define('MODULE_PAYMENT_PAYPALR_ERROR_CREDS_NEEDED', 'Das <var>paypalr</var>-Zahlungsmodul kann erst aktiviert werden, wenn Sie gültige Anmeldedaten für Ihre <b>%s</b>-Website angeben.');
define('MODULE_PAYMENT_PAYPALR_ERROR_INVALID_CREDS', 'Die <b>%s</b> Anmeldedaten für das <var>paypalr</var> Zahlungsmodul sind ungültig.');
define('MODULE_PAYMENT_PAYPALR_AUTO_DISABLED', ' Das Zahlungsmodul wurde automatisch deaktiviert.');

// -----
// Storefront-Nachrichten.
//
define('MODULE_PAYMENT_PALPALR_PAYING_WITH_PAYPAL', 'ZPagamento tramite PayPal Wallet'); //- Wird von der Bestätigungsmethode verwendet, wenn über PayPal Checkout (paypal) bezahlt wird
define('MODULE_PAYMENT_PAYPALR_TEXT_NOTIFICATION_MISSING', 'Al momento non siamo in grado di elaborare il tuo pagamento %s. Contattaci se hai bisogno di assistenza.'); //- %s wird mit MODULE_PAYMENT_PAYPALR_TEXT_TITLE ausgefüllt
define('MODULE_PAYMENT_PAYPALR_TEXT_GENERAL_ERROR', 'Al momento non siamo in grado di elaborare il tuo pagamento %s. Contattaci se hai bisogno di assistenza.'); //- %s wird mit MODULE_PAYMENT_PAYPALR_TEXT_TITLE ausgefüllt
define('MODULE_PAYMENT_PAYPALR_TEXT_STATUS_MISMATCH', 'Non siamo riusciti a elaborare la tua richiesta di pagamento.');
define('MODULE_PAYMENT_PAYPALR_TEXT_PLEASE_NOTE', 'Si prega di notare:');
define('MODULE_PAYMENT_PAYPALR_UNSUPPORTED_BILLING_COUNTRY', 'Il Paese indicato nell\'indirizzo di fatturazione non è supportato da PayPal; non è possibile effettuare pagamenti con carta di credito.');
define('MODULE_PAYMENT_PAYPALR_UNSUPPORTED_SHIPPING_COUNTRY', 'Il Paese indicato come indirizzo di consegna non è supportato da PayPal; non è possibile effettuare pagamenti con carta di credito.');

// -----
// Storefront-Text, der zum Erstellen einer für den Kunden sichtbaren „after_process“-Notiz in der
// Bestellstatus-Historie verwendet wird.
define('MODULE_PAYMENT_PAYPALR_TRANSACTION_ID','Transaktions-ID: '); //- Sollte mit einem Leerzeichen enden
define('MODULE_PAYMENT_PAYPALR_TRANSACTION_TYPE','Metodo di pagamento: PayPal Checkout (%s)'); //- %s wird entweder mit 'paypal' oder 'card' ausgefüllt
define('MODULE_PAYMENT_PAYPALR_TRANSACTION_PAYMENT_STATUS','Stato del pagamento: '); //- Sollte mit einem Leerzeichen enden
define('MODULE_PAYMENT_PAYPALR_TRANSACTION_AMOUNT','Importo: '); //- Sollte mit einem Leerzeichen enden
define('MODULE_PAYMENT_PAYPALR_BUYER_EMAIL','Email: ');  //- Sollte mit einem Leerzeichen enden
define('MODULE_PAYMENT_PAYPALR_FUNDING_SOURCE','Metodo di pagamento: ');  //- Sollte mit einem Leerzeichen enden

// Wird von der javascript_validation-Methode des Zahlungsmoduls verwendet.
//
define('MODULE_PAYMENT_PAYPALR_TEXT_JS_CC_OWNER', '* Il nome del titolare della carta deve contenere almeno ' . CC_OWNER_MIN_LENGTH . ' caratteri.\n');
define('MODULE_PAYMENT_PAYPALR_TEXT_JS_CC_NUMBER', '* Il numero della carta di credito deve essere composto da almeno  ' . CC_NUMBER_MIN_LENGTH . ' caratteri.\n');
define('MODULE_PAYMENT_PAYPALR_TEXT_JS_CC_CVV', '* Il numero CVV a 3 o 4 cifre deve essere inserito sul retro della carta di credito (o sul fronte nel caso delle carte American Express).');

// -----
// Bei der Verarbeitung von Kreditkarten verwendete Konstanten
//
define('MODULE_PAYMENT_PAYPALR_CC_OWNER', 'Nome del titolare della carta:');
define('MODULE_PAYMENT_PAYPALR_CC_TYPE', 'Tipo di carta di credito:');
define('MODULE_PAYMENT_PAYPALR_CC_NUMBER', 'Numero della carta di credito:');
define('MODULE_PAYMENT_PAYPALR_CC_EXPIRES', 'Data di scadenza:');
define('MODULE_PAYMENT_PAYPALR_CC_CVV', 'Numero CVV:');

define('MODULE_PAYMENT_PAYPALR_TEXT_CVV_LENGTH', 'Il <em>numero CVV</em> della tua carta %1$s, che termina con <var>%2$s</var>, deve essere composto da %3$u cifre.'); //- %1$s ist der Kartentyp, %2$s ist das letzte r, %3$u ist die CVV-Länge
define('MODULE_PAYMENT_PAYPALR_TEXT_BAD_CARD', 'Ci scusiamo per l\'inconveniente, ma il tipo di carta di credito da te inserito non è accettato. Ti preghiamo di utilizzare un\'altra carta di credito.');

define('MODULE_PAYMENT_PAYPALR_TEXT_CC_ERROR', 'Si è verificato un errore durante il tentativo di elaborare la tua carta di credito.');
define('MODULE_PAYMENT_PAYPALR_TEXT_CARD_DECLINED', 'La carta che termina con <var>%s</var> è stata rifiutata.'); //- %s ist die letzten 4 Stellen der Kartennummer.
define('MODULE_PAYMENT_PAYPALR_TEXT_DECLINED_REASON_UNKNOWN', 'Se continui a ricevere questo messaggio, ti preghiamo di contattarci indicando il codice motivo %s.'); //- %s ist ['processor_response']['response_code']

define('MODULE_PAYMENT_PAYPALR_TEXT_TRY_AGAIN', 'Riprova, seleziona un metodo di pagamento alternativo o contattaci se hai bisogno di aiuto.');

define('MODULE_PAYMENT_PAYPALR_CARD_PROCESSING', 'Effettuando il pagamento con la tua carta, confermi che i tuoi dati saranno trattati da PayPal in conformità con %s disponibile su PayPal.com.'); //- %s wird mit einem Link ausgefüllt
define('MODULE_PAYMENT_PAYPALR_PAYPAL_PRIVACY_STMT', 'Informativa sulla privacy di PayPal');
define('MODULE_PAYMENT_PAYPALR_PAYPAL_PRIVACY_LINK', 'https://www.paypal.com/it/legalhub/paypal/privacy-full');

// -----
// Warnmeldungen für Geschäftsinhaber/Administrator
//
define('MODULE_PAYMENT_PAYPALR_ALERT_SUBJECT', 'ALARM: PayPal Checkout Error (%s)'); //- %s ist eine zusätzliche Fehlerbeschreibung, siehe unten
define('MODULE_PAYMENT_PAYPALR_ALERT_SUBJECT_CONFIGURATION', 'Konfiguration');
define('MODULE_PAYMENT_PAYPALR_ALERT_SUBJECT_ORDER_ATTN', 'Bestellung erfordert Ihre Aufmerksamkeit');
define('MODULE_PAYMENT_PAYPALR_ALERT_SUBJECT_UNKNOWN_DENIAL', 'Unbekannter Code für die Ablehnung');
define('MODULE_PAYMENT_PAYPALR_ALERT_SUBJECT_LOST_STOLEN_CARD', 'Verlorene/Gestohlene/Betrügerische Karte');
define('MODULE_PAYMENT_PAYPALR_ALERT_SUBJECT_TOTAL_MISMATCH', 'Berechnungsfehler');
define('MODULE_PAYMENT_PAYPALR_ALERT_SUBJECT_CONFIRMATION_ERROR', 'Zahlungsauswahl bestätigen');

define('MODULE_PAYMENT_PAYPALR_ALERT_ORDER_CREATION', 'Der Status für die Bestellung Nr. %1$u wurde aufgrund eines PayPal-Antwortstatus von %2$s auf Ausstehend gesetzt.');
define('MODULE_PAYMENT_PAYPALR_ALERT_MISSING_OBSERVER', 'Der Observer des Zahlungsmoduls (auto.paypalrestful.php) wurde nicht geladen; das Zahlungsmodul wurde deaktiviert.');
define('MODULE_PAYMENT_PAYPALR_ALERT_MISSING_NOTIFICATIONS', 'Die erforderlichen Benachrichtigungen in der Klasse order_total.php wurden nicht angewendet; das Zahlungsmodul kann keine Bestellungen aufgeben.');
define('MODULE_PAYMENT_PAYPALR_ALERT_ORDER_CREATE', 'Beim Versuch, eine Bestellung zu initiieren, wurde von PayPal ein Fehler zurückgegeben. Aus Kulanzgründen wurde Ihrem Kunden nur der Fehlercode angezeigt. Die Details des Fehlers sind unten aufgeführt:' . '\n\n');
define('MODULE_PAYMENT_PAYPALR_ALERT_TOTAL_MISMATCH', 'Es wurde eine Diskrepanz zwischen dem Gesamtwert einer Bestellung und ihrer Aufschlüsselung festgestellt. Die Bestellung wird ohne Artikel und Kostenaufschlüsselung an PayPal übermittelt:');
define('MODULE_PAYMENT_PAYPALR_ALERT_CONFIRMATION_ERROR', 'Beim Versuch, die Zahlungsauswahl eines Kunden aus seiner PayPal-Geldbörse zu bestätigen, wurde eine nicht verarbeitbare Rückgabe von PayPal empfangen.');
define('MODULE_PAYMENT_PAYPALR_ALERT_EXTERNAL_TXNS', 'Überprüfen Sie den Status der Bestellung #%u. PayPal-Transaktionen wurden außerhalb der Verarbeitung des Zahlungsmoduls hinzugefügt.');

// -----
// Warnmeldungen bei unbekannten „ABGELEHNT“-Gründen und verlorenen/gestohlenen/betrügerisch verwendeten Karten.
// -----

// -----
// %1$s: ['processor_response']['response_code']
// %2$s: $_SESSION['customer_first_name']
// %3$s: $_SESSION['customer_last_name']
// $4%u: $_SESSION['customer_id']
//
define('MODULE_PAYMENT_PAYPALR_ALERT_UNKNOWN_DENIAL','PayPal hat einen unbekannten Antwortcode (%1$s) für eine abgelehnte Kreditkartenzahlung zurückgegeben.' . '\n\n' .
'Die Zahlung wurde von %2$s %3$s (Kunden-ID %4$u) versucht. Formatierte Kartendetails folgen:' . '\n\n');

// -----
// %1$s: Eine der beiden folgenden Sprachkonstanten.
// %2$s: $_SESSION['customers_ip_address']
// %3$s: $_SESSION['customer_first_name']
// %4$s: $_SESSION['customer_last_name']
// $5%u: $_SESSION['customer_id']
//
define('MODULE_PAYMENT_PAYPALR_ALERT_LOST_STOLEN_CARD','Es wurde versucht, eine Kreditkartenzahlung mit einer %1$s-Karte von der IP-Adresse %2$s durchzuführen.' . '\n\n' .
'Die Zahlung wurde von %3$s %4$s (Kunden-ID %5$u) versucht. Es folgen formatierte Kartendetails:' . '\n\n');
define('MODULE_PAYMENT_PAYPALR_CARD_LOST', 'verloren oder gestohlen');
define('MODULE_PAYMENT_PAYPALR_CARD_FRAUDULENT', 'betrügerisch');

// -----
// Für diese Nachrichten ist %1$s der Kartentyp und %2$s die letzten 4 Stellen der Kartennummer.
//
define('MODULE_PAYMENT_PAYPALR_TEXT_CC_EXPIRED', 'Die %1$s-Karte, die mit <var>%2$s</var> endet, ist abgelaufen.');
define('MODULE_PAYMENT_PAYPALR_TEXT_INSUFFICIENT_FUNDS', 'Die %1$s-Karte, die mit <var>%2$s</var> endet, verfügt über unzureichende Mittel.');
define('MODULE_PAYMENT_PAYPALR_TEXT_CVV_FAILED', 'Die von Ihnen eingegebene CVV-Nummer für die %1$s-Karte mit der Endung <var>%2$s</var> ist nicht korrekt.');

// -----
// $1$s ... MODULE_PAYMENT_PAYPALR_TEXT_TITLE
// $2%s ... Der von PayPal zurückgegebene Fehlercode.
//
define('MODULE_PAYMENT_PAYPALR_TEXT_CREATE_ORDER_ISSUE', 'Wir können Ihre %1$s-Zahlung derzeit nicht verarbeiten. Bitte kontaktieren Sie uns, um Unterstützung zu erhalten, und geben Sie uns diesen Code: <b>%2$s</b>.');

// -----
// Schaltflächen auf der Seite „checkout_payment“; weitere Informationen finden Sie unter https://www.paypal.com/bm/webapps/mpp/logo-center.
//
define('MODULE_PAYMENT_PAYPALR_BUTTON_ALTTEXT', 'Klicken Sie hier, um mit Ihrer PayPal-Geldbörse zu bezahlen');
define('MODULE_PAYMENT_PAYPALR_BUTTON_COLOR', 'YELLOW'); //- One of WHITE, YELLOW, GREY or BLUE; defaults to YELLOW.
define('MODULE_PAYMENT_PAYPALR_BUTTON_IMG_YELLOW', 'https://www.paypalobjects.com/digitalassets/c/website/marketing/apac/C2/logos-buttons/optimize/44_Yellow_PayPal_Pill_Button.png');
define('MODULE_PAYMENT_PAYPALR_BUTTON_IMG_GREY', 'https://www.paypalobjects.com/digitalassets/c/website/marketing/apac/C2/logos-buttons/optimize/44_Grey_PayPal_Pill_Button.png');
define('MODULE_PAYMENT_PAYPALR_BUTTON_IMG_BLUE', 'https://www.paypalobjects.com/digitalassets/c/website/marketing/apac/C2/logos-buttons/optimize/44_Blue_PayPal_Pill_Button.png');
define('MODULE_PAYMENT_PAYPALR_BUTTON_IMG_WHITE', 'https://www.paypalobjects.com/webstatic/mktg/Logo/pp-logo-150px.png');

define('MODULE_PAYMENT_PAYPALR_CHOOSE_PAYPAL', 'PayPal Wallet:');
define('MODULE_PAYMENT_PALPALR_CHOOSE_CARD', 'Kreditkarte:');
define('MODULE_PAYMENT_PAYPALR_LOGO_SVG', '"data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAxcHgiIGhlaWdodD0iMzIiIHZpZXdCb3g9IjAgMCAxMDEgMzIiIHByZXNlcnZlQXNw ZWN0UmF0aW89InhNaW5ZTWluIG1lZXQiIHhtbG5zPSJodHRwOiYjeDJGOyYjeDJGO3d3dy53My5vcmcmI3gyRjsyMDAwJiN4MkY7c3ZnIj48cGF0aCBmaWxsPSIjMDAzMDg3IiB kPSJNIDEyLjIzNyAyLjggTCA0LjQzNyAyLjggQyAzLjkzNyAyLjggMy40MzcgMy4yIDMuMzM3IDMuNyBMIDAuMjM3IDIzLjcgQyAwLjEzNyAyNC4xIDAuNDM3IDI0LjQgMC44MzcgMjQu NCBMIDQuNTM3IDI0LjQgQyA1LjAzNyAyNC40IDUuNTM3IDI0IDUuNjM3IDIzLjUgTCA2LjQzNyAxOC4xIEMgNi41MzcgMTcuNiA2LjkzNyAxNy4yIDcuNTM3IDE3LjIgTCAxMC4wMz cgMTcuMiBDIDE1LjEzNyAxNy4yIDE4LjEzNyAxNC43IDE4LjkzNyA5LjggQyAxOS4yMzcgNy43IDE4LjkzNyA2IDE3LjkzNyA0LjggQyAxNi44MzcgMy41IDE0LjgzNyAyLjggMTIuMjM3IDI uOCBaIE0gMTMuMTM3IDEwLjEgQyAxMi43MzcgMTIuOSAxMC41MzcgMTIuOSA4LjUzNyAxMi45IEwgNy4zMzcgMTIuOSBMIDguMTM3IDcuNyBDIDguMTM3IDcuNCA4LjQzNyA3LjIgOC43Mz cgNy4yIEwgOS4yMzcgNy4yIEMgMTAuNjM3IDcuMiAxMS45MzcgNy4yIDEyLjYzNyA4IEMgMTMuMTM3IDguNCAxMy4zMzcgOS4xIDEzLjEzNyAxMC4xIFoiPjwvcGF0aD48cGF0aCBmaW xsPSIjMDAzMDg3IiBkPSJNIDM1LjQzNyAxMCBMIDMxLjczNyAxMCBDIDMxLjQzNyAxMCAzMS4xMzcgMTAuMiAzMS4xMzcgMTAuNSBMIDMwLjkzNyAxMS41IEwgMzAuNjM3IDExLjEgQyAy OS44MzcgOS45IDI4LjAzNyA5LjUgMjYuMjM3IDkuNSBDIDIyLjEzNyA5LjUgMTguNjM3IDEyLjYgMTcuOTM3IDE3IEMgMTcuNTM3IDE5LjIgMTguMDM3IDIxLjMgMTkuMzM3IDIyLjcgQy AyMC40MzcgMjQgMjIuMTM3IDI0LjYgMjQuMDM3IDI0LjYgQyAyNy4zMzcgMjQuNiAyOS4yMzcgMjIuNSAyOS4yMzcgMjIuNSBMIDI5LjAzNyAyMy41IEMgMjguOTM3IDIzLj kgMjkuMjM3IDI0LjMgMjkuNjM3IDI0LjMgTCAzMy4wMzcgMjQuMyBDIDMzLjUzNyAyNC4zIDM0LjAzNyAyMy45IDM0LjEzNyAyMy40IEwgMzYuMTM3IDEwLjYgQyAzNi4yMzcgM TAuNCAzNS44MzcgMTAgMzUuNDM3IDEwIFogTSAzMC4zMzcgMTcuMiBDIDI5LjkzNyAxOS4zIDI4LjMzNyAyMC44IDI2LjEzNyAyMC44IEMgMjUuMDM3IDIwLjggMjQuMjM3IDIwLjUgMj MuNjM3IDE5LjggQyAyMy4wMzcgMTkuMSAyMi44MzcgMTguMiAyMy4wMzcgMTcuMiBDIDIzLjMzNyAxNS4xIDI1LjEzNyAxMy42IDI3LjIzNyAxMy42IEMgMjguMzM3IDEzLjYgMjkuMTM3IDE 0IDI5LjczNyAxNC42IEMgMzAuMjM3IDE1LjMgMzAuNDM3IDE2LjIgMzAuMzM3IDE3LjIgWiI+PC9wYXRoPjxwYXRoIGZpbGw9IiMwMDMwODciIGQ9Ik0gNTUuMzM3IDEwIEwgN TEuNjM3IDEwIEMgNTEuMjM3IDEwIDUwLjkzNyAxMC4yIDUwLjczNyAxMC41IEwgNDUuNTM3IDE4LjEgTCA0My4zMzcgMTAuOCBDIDQzLjIzNyAxMC4zIDQyLjczNyAxMCA0Mi4zMzcgM TAgTCAzOC42MzcgMTAgQyAzOC4yMzcgMTAgMzcuODM3IDEwLjQgMzguMDM3IDEwLjkgTCA0Mi4xMzcgMjMgTCAzOC4yMzcgMjguNCBDIDM3LjkzNyAyOC44IDM4LjIzNyAyOS40 IDM4LjczNyAyOS40IEwgNDIuNDM3IDI5LjQgQyA0Mi44MzcgMjkuNCA0My4xMzcgMjkuMiA0My4zMzcgMjguOSBMIDU1LjgzNyAxMC45IEMgNTYuMTM3IDEwLjYgNTUuODM3IDE wIDU1LjMzNyAxMCBaIj48L3BhdGg+PHBhdGggZmlsbD0iIzAwOWNkZSIgZD0iTSA2Ny43MzcgMi44IEwgNTkuOTM3IDIuOCBDIDU5LjQzNyAyLjggNTguOTM3IDMuMiA1OC44MzcgMy43 IEwgNTUuNzM3IDIzLjYgQyA1NS42MzcgMjQgNTUuOTM3IDI0LjMgNTYuMzM3IDI0LjMgTCA2MC4zMzcgMjQuMyBDIDYwLjczNyAyNC4zIDYxLjAzNyAyNCA2MS4wMzcgMjMu NyBMIDYxLjkzNyAxOCBDIDYyLjAzNyAxNy41IDYyLjQzNyAxNy4xIDYzLjAzNyAxNy4xIEwgNjUuNTM3IDE3LjEgQyA3MC42MzcgMTcuMSA3My42MzcgMTQuNiA3NC40MzcgOS43IEMg NzQuNzM3IDcuNiA3NC40MzcgNS45IDczLjQzNyA0LjcgQyA3Mi4yMzcgMy41IDcwLjMzNyAyLjggNjcuNzM3IDIuOCBaIE0gNjguNjM3IDEwLjEgQyA2OC4yMzcgMTIu OSA2Ni4wMzcgMTIuOSA2NC4wMzcgMTIuOSBMIDYyLjgzNyAxMi45IEwgNjMuNjM3IDcuNyBDIDYzLjYzNyA3LjQgNjMuOTM3IDcuMiA2NC4yMzcgNy4yIEwgNjQuNzM3IDcuMiBDIDY 2LjEzNyA3LjIgNjcuNDM3IDcuMiA2OC4xMzcgOCBDIDY4LjYzNyA4LjQgNjguNzM3IDkuMSA2OC42MzcgMTAuMSBaIj48L3BhdGg+PHBhdGggZmlsbD0iIzAwOWNkZSIgZD0i TSA5MC45MzcgMTAgTCA4Ny4yMzcgMTAgQyA4Ni45MzcgMTAgODYuNjM3IDEwLjIgODYuNjM3IDEwLjUgTCA4Ni40MzcgMTEuNSBMIDg2LjEzNyAxMS4xIEMgODUuMzM3IDkuOSA4 My41MzcgOS41IDgxLjczNyA5LjUgQyA3Ny42MzcgOS41IDc0LjEzNyAxMi42IDczLjQzNyAxNyBDIDczLjAzNyAxOS4yIDczLjUzNyAyMS4zIDc0LjgzNyAyMi43IEMgNzUuOTM3 IDI0IDc3LjYzNyAyNC42IDc5LjUzNyAyNC42IEMgODIuODM3IDI0LjYgODQuNzM3IDIyLjUgODQuNzM3IDIyLjUgTCA4NC41MzcgMjMuNSBDIDg0LjQzNyAyMy45IDg0LjczNyAy NC4zIDg1LjEzNyAyNC4zIEwgODguNTM3IDI0LjMgQyA4OS4wMzcgMjQuMyA4OS41MzcgMjMuOSA4OS42MzcgMjMuNCBMIDkxLjYzNyAxMC42IEMgOTEuNjM3IDEwLjQgOTEuMzM3IDE wIDkwLjkzNyAxMCBaIE0gODUuNzM3IDE3LjIgQyA4NS4zMzcgMTkuMyA4My43MzcgMjAuOCA4MS41MzcgMjAuOCBDIDgwLjQzNyAyMC44IDc5LjYzNyAyMC41IDc5LjAzNyAxOS44I EMgNzguNDM3IDE5LjEgNzguMjM3IDE4LjIgNzguNDM3IDE3LjIgQyA3OC43MzcgMTUuMSA4MC41MzcgMTMuNiA4Mi42MzcgMTMuNiBDIDgzLjczNyAxMy42IDg0LjUzNyAxNCA4NS4x MzcgMTQuNiBDIDg1LjczNyAxNS4zIDg1LjkzNyAxNi4yIDg1LjczNyAxNy4yIFoiPjwvcGF0aD48cGF0aCBmaWxsPSIjMDA5Y2RlIiBkPSJNIDk1LjMzNyAzLjMgTCA5Mi4xMzcgMj MuNiBDIDkyLjAzNyAyNCA5Mi4zMzcgMjQuMyA5Mi43MzcgMjQuMyBMIDk1LjkzNyAyNC4zIEMgOTYuNDM3IDI0LjMgOTYuOTM3IDIzLjkgOTcuMDM3IDIzLjQgTCAxMDAuMjM3IDMuNSBDIDEw MC4zMzcgMy4xIDEwMC4wMzcgMi44IDk5LjYzNyAyLjggTCA5Ni4wMzcgMi44IEMgOTUuNjM3IDIuOCA5NS40MzcgMyA5NS4zMzcgMy4zIFoiPjwvcGF0aD48L3N2Zz4"');

// -----
// Administratormeldungen, aus der Anzeige einer Bestellung, beim Anzeigen des PayPal-Transaktionsverlaufs.
//
define('MODULE_PAYMENT_PAYPALR_TEXT_GETDETAILS_ERROR', 'Beim Abrufen der PayPal-Transaktionsdetails ist ein Problem aufgetreten.');
define('MODULE_PAYMENT_PAYPALR_NO_RECORDS', 'In der Datenbank wurden keine \'%1$s\' Datensätze für die Bestellung #%2$u gefunden.');
define('MODULE_PAYMENT_PAYPALR_EXTERNAL_ADDITION', 'PayPal-Transaktionen wurden außerhalb der Verarbeitung des Zahlungsmoduls hinzugefügt. Überprüfen Sie, ob der Status der Bestellung korrekt ist!');

// -----
// Wird verwendet, wenn der Administrator die Zahlungstransaktionen in der
// Detailansicht einer Bestellung anzeigt.
//
define('MODULE_PAYMENT_PAYPALR_NO_RECORDS_FOUND', 'Für diese Bestellung sind keine PayPal-Transaktionen in der Datenbank verzeichnet.');

define('MODULE_PAYMENT_PAYPALR_TXN_TABLE_CAPTION', 'PayPal-Transaktionen');
define('MODULE_PAYMENT_PAYPALR_PAYMENTS_TABLE_CAPTION', 'Abgewickelte Zahlungen');
define('MODULE_PAYMENT_PAYPALR_PAYMENTS_TABLE_NOTE', 'Hinweis: Gebühren für Rückerstattungen werden von PayPal rückgängig gemacht!');
define('MODULE_PAYMENT_PAYPALR_PAYMENTS_NONE', 'Keine derzeit abgewickelten Zahlungen.');
define('MODULE_PAYMENT_PAYPALR_PAYMENTS_TOTAL', 'Abgewickelte Summen:');
define('MODULE_PAYMENT_PAYPALR_NAME_EMAIL_ID', 'Name/E-Mail/ID des Zahlers');
define('MODULE_PAYMENT_PAYPALR_PAYER_EMAIL', 'E-Mail-Adresse des Zahlers:');
define('MODULE_PAYMENT_PAYPALR_PAYER_ID', 'Zahler ID:');
define('MODULE_PAYMENT_PAYPALR_PAYER_STATUS', 'Zahler Status:');
define('MODULE_PAYMENT_PAYPALR_PAYMENT_TYPE', 'Zahlungsart:');
define('MODULE_PAYMENT_PAYPALR_PAYMENT_STATUS', 'Zahlung Status:');
define('MODULE_PAYMENT_PAYPALR_PENDING_REASON', 'Ausstehender Grund:');
define('MODULE_PAYMENT_PAYPALR_INVOICE', 'Rechnung:');
define('MODULE_PAYMENT_PAYPALR_PAYMENT_DATE', 'Zahlungsdatum:');
define('MODULE_PAYMENT_PAYPALR_GROSS_AMOUNT', 'Bruttobetrag:');
define('MODULE_PAYMENT_PAYPALR_PAYMENT_FEE', 'Zahlungsgebühr:');
define('MODULE_PAYMENT_PAYPALR_SETTLE_AMOUNT', 'Abgerechneter Betrag:');
define('MODULE_PAYMENT_PAYPALR_EXCHANGE_RATE', 'Wechselkurs:');

define('MODULE_PAYMENT_PAYPALR_TXN_TYPE', 'Txn Typ:');
define('MODULE_PAYMENT_PAYPALR_TXN_ID', 'Txn ID:');
define('MODULE_PAYMENT_PAYPALR_TXN_PARENT_TXN_ID', 'Parent Txn ID / Txn ID:');
define('MODULE_PAYMENT_PAYPALR_ACTION', 'Aktion');
define('MODULE_PAYMENT_PAYPALR_ACTION_DETAILS', 'Details');
define('MODULE_PAYMENT_PAYPALR_ACTION_REAUTH', 'Erneut autorisieren');
define('MODULE_PAYMENT_PAYPALR_ACTION_VOID', 'Annulieren');
define('MODULE_PAYMENT_PAYPALR_ACTION_CAPTURE', 'Erfassen');
define('MODULE_PAYMENT_PAYPALR_ACTION_REFUND', 'Rückerstatten');
define('MODULE_PAYMENT_PAYPALR_TXN_STATUS', 'Txn Status');

define('MODULE_PAYMENT_PAYPALR_CONFIRM', 'Bestätigen');
define('MODULE_PAYMENT_PAYPALR_DAYSTOSETTLE', 'Tage bis zur Abrechnung:');
define('MODULE_PAYMENT_PAYPALR_AMOUNT', 'Betrag:');
define('MODULE_PAYMENT_PAYPALR_CUSTOMER_NOTE', 'Kundenhinweis:');
define('MODULE_PAYMENT_PAYPALR_DATE_CREATED', 'Erstellungsdatum:');
define('MODULE_PAYMENT_PAYPALR_AMOUNT_RANGE', 'Geben Sie einen Betrag zwischen %1$s 1,00 und %1$s %2$s ein.');
define('MODULE_PAYMENT_PAYPALR_NOTES', 'Hinweise:');

// -----
// Im Modal „Details“ verwendete Konstanten.
//
define('MODULE_PAYMENT_PAYPALR_DETAILS_TITLE', 'PayPal-Transaktionsdetails (%s)'); //- %s ist eine der folgenden beiden Zeichenketten
define('MODULE_PAYMENT_PAYPALR_DETAILS_TYPE_PAYPAL', 'PayPal Wallet');
define('MODULE_PAYMENT_PAYPALR_DETAILS_TYPE_CARD', 'Kreditkarte');
define('MODULE_PAYMENT_PAYPALR_BUYER_INFO', 'Käuferinformationen');
define('MODULE_PAYMENT_PAYPALR_PAYER_NAME', 'Name des Zahlenden:');
define('MODULE_PAYMENT_PAYPALR_PAYER_EMAIL', 'E-Mail-Adresse des Zahlers:');
define('MODULE_PAYMENT_PAYPALR_BUSINESS_NAME', 'Firmenname:');
define('MODULE_PAYMENT_PAYPALR_ADDRESS_NAME', 'Name des Empfängers:');
define('MODULE_PAYMENT_PAYPALR_ADDRESS_STREET', 'Straße:');
define('MODULE_PAYMENT_PAYPALR_ADDRESS_CITY', 'Stadt:');
define('MODULE_PAYMENT_PAYPALR_ADDRESS_STATE', 'Bundesland:');
define('MODULE_PAYMENT_PAYPALR_ADDRESS_ZIP', 'Postleitzahl:');
define('MODULE_PAYMENT_PAYPALR_ADDRESS_COUNTRY', 'Land:');
define('MODULE_PAYMENT_PAYPALR_SELLER_INFO', 'Verkäuferinformationen');
define('MODULE_PAYMENT_PAYPALR_CART_ITEMS', 'Warenkorbpositionen:');
define('MODULE_PAYMENT_PAYPALR_MERCHANT_NAME', 'Verkäufername:');
define('MODULE_PAYMENT_PAYPALR_MERCHANT_EMAIL', 'Verkäufer-E-Mail-Adresse:');
define('MODULE_PAYMENT_PAYPALR_MERCHANT_ID', 'Händler-ID:');
define('MODULE_PAYMENT_PAYPALR_SELLER_PROTECTION', 'Verkäuferschutz:');
define('MODULE_PAYMENT_PAYPALR_PROCESSOR_RESPONSE' , 'Processor Rückmeldung:');
define('MODULE_PAYMENT_PAYPALR_AVS_CODE', 'AVS Code (%s)');
define('MODULE_PAYMENT_PAYPALR_RESPONSE_CODE', 'Rückmeldung Code (%s)');
define('MODULE_PAYMENT_PAYPALR_CVV_CODE', 'CVV Code (%s)');
define('MODULE_PAYMENT_PAYPALR_AUTH_RESULT', 'Authentifizierung Ergebnis:');
define('MODULE_PAYMENT_PAYPALR_LIABILITY', 'Haftungsumkehr (%s)');
define('MODULE_PAYMENT_PAYPALR_AUTH_STATUS', 'Authentifizierung Status (%s)');
define('MODULE_PAYMENT_PAYPALR_ENROLL_STATUS', 'Anmeldestatus (%s)');
define('MODULE_PAYMENT_PAYPALR_AMOUNT_MISMATCH', 'Abweichung des Bestellbetrags: %s'); //- %s ist der Basisbetrag für die Bestellberechnung/Währungscode
define('MODULE_PAYMENT_PAYPALR_CALCULATED_AMOUNT', 'Berechneter Betrag:');
define('MODULE_PAYMENT_PAYPALR_INVOICE_NUMBER', 'Rechnungsnummer #:');

// -----
// Im Modal „Rückerstattungen“ verwendete Konstanten.
//
define('MODULE_PAYMENT_PAYPALR_REFUND_TITLE', 'Rückerstattung einer Zahlung');
define('MODULE_PAYMENT_PAYPALR_REFUND_INSTRUCTIONS', 'Sie können eine erfasste Zahlung ganz oder teilweise zurückerstatten.');
define('MODULE_PAYMENT_PAYPALR_REFUND_NOTE1', 'Bei einer <em>vollständigen</em> Rückerstattung wird der verbleibende, nicht erstattete Betrag der eingezogenen Zahlung erstattet.');
define('MODULE_PAYMENT_PAYPALR_REFUND_NOTE2', 'Bei einer <em>teilweisen</em> Rückerstattung wird ein Teil der eingezogenen Zahlung erstattet.');
define('MODULE_PAYMENT_PAYPALR_REFUND_NOTE3', 'Sie können mehrere <em>teilweise</em> Rückerstattungen bis zur Höhe des verbleibenden nicht erstatteten Betrags vornehmen.');
define('MODULE_PAYMENT_PAYPALR_REFUND_CAPTURE_ID', 'Capture Txn Id:');
define('MODULE_PAYMENT_PAYPALR_REMAINING_TO_REFUND', 'Verbleibender Rückerstattungsbetrag:');
define('MODULE_PAYMENT_PAYPALR_REFUND_AMOUNT', 'Zu erstattender Betrag:');
define('MODULE_PAYMENT_PAYPALR_REFUND_FULL', 'Vollständige Rückerstattung?');
define('MODULE_PAYMENT_PAYPALR_REFUND_DEFAULT_MESSAGE', 'Rückerstattung durch Shopinhaber');

define('MODULE_PAYMENT_PAYPALR_REFUND_PARAM_ERROR', 'Beim Versuch, eine Zahlung für diese Bestellung zu erstatten, wurden ungültige Parameter (CP %u) angegeben. Bitte versuchen Sie es erneut.');
define('MODULE_PAYMENT_PAYPALR_REFUND_ERROR', 'Bei der Rückerstattung der Transaktion ist ein Problem aufgetreten.');

define('MODULE_PAYMENT_PAYPALR_REFUND_COMPLETE', 'Eine Rückerstattung in Höhe von %s wurde abgeschlossen.');

// -----
// Im Modal „Erneut autorisieren“ verwendete Konstanten.
//
define('MODULE_PAYMENT_PAYPALR_REAUTH_TITLE', 'Bestellung erneut autorisieren');
define('MODULE_PAYMENT_PAYPALR_REAUTH_INSTRUCTIONS', 'Um sicherzustellen, dass die Mittel noch verfügbar sind, können Sie eine Zahlung nach Ablauf der ursprünglichen dreitägigen Frist erneut autorisieren.');
define('MODULE_PAYMENT_PAYPALR_REAUTH_NOTE1', 'Innerhalb des 29-tägigen Autorisierungszeitraums können Sie nach Ablauf der dreitägigen Gültigkeitsdauer der zuvor erteilten Autorisierung mehrere erneute Autorisierungen erteilen.');
define('MODULE_PAYMENT_PAYPALR_REAUTH_NOTE2', 'Wenn seit dem Datum der ursprünglichen Autorisierung 30 Tage vergangen sind, müssen Sie eine autorisierte Zahlung erstellen, anstatt die ursprüngliche erneut zu autorisieren.');
define('MODULE_PAYMENT_PAYPALR_REAUTH_NOTE3', 'Eine erneut autorisierte Zahlung hat selbst eine neue Gültigkeitsdauer von drei Tagen.');
define('MODULE_PAYMENT_PAYPALR_REAUTH_NOTE4', 'Sie können eine autorisierte Zahlung <em>einmal</em> für bis zu 115 % des ursprünglich autorisierten Betrags (%s) erneut autorisieren, wobei eine Erhöhung von 75 USD nicht überschritten werden darf.');

define('MODULE_PAYMENT_PAYPALR_REAUTH_ORIGINAL', 'Ursprünglicher Betrag:');
define('MODULE_PAYMENT_PAYPALR_REAUTH_NEW_AMOUNT', 'Genehmigter Betrag:');
define('MODULE_PAYMENT_PAYPALR_REAUTH_DAYS_FROM_LAST', 'Tage seit der letzten Autorisierung:');
define('MODULE_PAYMENT_PAYPALR_REAUTH_NOT_POSSIBLE', 'Die Bestellung kann nicht erneut autorisiert werden, da eine Karenzzeit aktiv ist.');

define('MODULE_PAYMENT_PAYPALR_REAUTH_PARAM_ERROR', 'Beim Versuch, diese Bestellung erneut zu autorisieren, wurden ungültige Parameter angegeben (CP %u); bitte versuchen Sie es erneut.');
define('MODULE_PAYMENT_PAYPALR_REAUTH_ERROR', 'Bei der Autorisierung der Transaktion ist ein Problem aufgetreten.');
define('MODULE_PAYMENT_PAYPALR_REAUTH_TOO_SOON', 'Eine erneute Autorisierung ist nur einmal zwischen Tag 4 und Tag 29 ab dem Datum der ursprünglichen Autorisierung zulässig.');

define('MODULE_PAYMENT_PAYPALR_REAUTH_COMPLETE', 'Eine erneute Autorisierung in Höhe von %s wurde abgeschlossen.');

// -----
// Im Modal „Erfassung“ verwendete Konstanten.
//
define('MODULE_PAYMENT_PAYPALR_CAPTURE_TITLE', 'Erfassung einer Autorisierung');
define('MODULE_PAYMENT_PAYPALR_CAPTURE_INSTRUCTIONS', 'Um alle oder einen Teil der ausstehenden Beträge für diese Bestellung einzuziehen, geben Sie unten den „Betrag“ ein, geben Sie an, ob dies der <b>letzte</b> Einzug für die Bestellung ist, und klicken Sie auf die Schaltfläche Einziehen.');
define('MODULE_PAYMENT_PAYPALR_CAPTURE_FINAL_TEXT', 'Letzte Erfassung?');
define('MODULE_PAYMENT_PAYPALR_CAPTURE_REMAINING', 'Restliche Gelder erfassen?');
define('MODULE_PAYMENT_PAYPALR_CAPTURED_SO_FAR', 'Zuvor erfasst:');
define('MODULE_PAYMENT_PAYPALR_REMAINING_TO_CAPTURE', 'Restbetrag zu erfassen:');
define('MODULE_PAYMENT_PAYPALR_CAPTURE_DEFAULT_MESSAGE', 'Vielen Dank für Ihre Bestellung.');

define('MODULE_PAYMENT_PAYPALR_CAPTURE_PARAM_ERROR', 'Beim Versuch, Gelder für diese Bestellung einzuziehen, wurden ungültige Parameter angegeben (CP %u); bitte versuchen Sie es erneut.');
define('MODULE_PAYMENT_PAYPALR_CAPTURE_ERROR', 'Beim Einziehen der Transaktion ist ein Problem aufgetreten.');
define('MODULE_PAYMENT_PAYPALR_CAPTURE_AMOUNT', 'Der eingezogene Betrag muss größer als null sein, es sei denn, Sie ziehen die verbleibenden Mittel ein.');

define('MODULE_PAYMENT_PAYPALR_CAPTURE_NO_REMAINING', 'Alle autorisierten Mittel für diese Bestellung wurden erfolgreich eingezogen.');
define('MODULE_PAYMENT_PAYPALR_CAPTURE_COMPLETE', 'Die Zahlung für die Bestellung Nr. %u wurde erfasst.');
define('MODULE_PAYMENT_PAYPALR_PARTIAL_CAPTURE', 'Teilweise erfasst.');
define('MODULE_PAYMENT_PAYPALR_FINAL_CAPTURE', 'Endgültige Erfassung.');

// -----
// Im „Void“-Modal verwendete Konstanten.
//
define('MODULE_PAYMENT_PAYPALR_VOID_TITLE', 'Autorisierung stornieren');
define('MODULE_PAYMENT_PAYPALR_VOID_INSTRUCTIONS', 'Um diese Transaktion zu stornieren, geben/kopieren Sie die Autorisierungs-ID in das untenstehende Eingabefeld ein und klicken Sie auf die Schaltfläche Stornieren.');
define('MODULE_PAYMENT_PAYPALR_VOID_AUTH_ID', 'Autorisierungs-ID:');
define('MODULE_PAYMENT_PAYPALR_VOID_DEFAULT_MESSAGE', 'Transaktion storniert.');

define('MODULE_PAYMENT_PAYPALR_VOID_PARAM_ERROR', 'Beim Versuch, eine Autorisierung für diese Bestellung zu stornieren, wurden ungültige Parameter angegeben. Bitte versuchen Sie es erneut.');
define('MODULE_PAYMENT_PAYPALR_VOID_BAD_AUTH_ID', 'Nur die <em>primäre</em> Autorisierung einer Bestellung kann storniert werden. Bitte versuchen Sie es erneut.');
define('MODULE_PAYMENT_PAYPALR_VOID_ERROR', 'Beim Stornieren der Transaktion ist ein Problem aufgetreten.');
define('MODULE_PAYMENT_PAYPALR_VOID_MEMO', 'Transaktion von %1$s storniert.');
define('MODULE_PAYMENT_PAYPALR_VOID_INVALID_TXN_ID', 'Die von Ihnen eingegebene Transaktions-ID (%1$s) wurde nicht gefunden. Bitte versuchen Sie es erneut.');
define('MODULE_PAYMENT_PAYPALR_VOID_COMPLETE', 'Die Zahlungsautorisierung für die Bestellung Nr. %u wurde storniert.');

if (IS_ADMIN_FLAG === true) {
define('MODULE_PAYMENT_PAYPALR_TEXT_ADMIN_DESCRIPTION','<b>PayPal Checkout (RESTful)</b>, v%s<br><br>
Dieses Modul verwendet die neue PayPal RESTful API und ermöglicht Zahlung via PayPal Wallet oder Kreditkarte via PayPal.<br>Eine detaillierte Installations- und Konfigurationsanleitung finden Sie auf:<br><a href="https://paypalcheckout.zen-cart-pro.at" target="_blank">paypalcheckout.zen-cart-pro.at</a>');
}

