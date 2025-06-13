# 157-modul-paypalr
PayPal Checkout RESTful API Zahlungsmodul für Zen Cart 1.5.7 deutsch

Hinweis: Freigegebene getestete Versionen für den Einsatz in Livesystemen ausschließlich unter Releases herunterladen:
* https://github.com/zencartpro/157-modul-paypalr/releases

Mit diesem Modul wird Zahlung via PayPal Checkout über die neue PayPal REST API im Shop integriert.
* Optional kann auch Kreditkartenzahlung via PayPal aktiviert werden, dazu ist für den Kunden kein PayPal Konto erforderlich
* Dieses Modul löst das bisherige PayPal Express Modul (paypalwpp) der deutschen Zen Cart Version ab, da PayPal die alte von diesem Modul verwendete NVP/SOAP API abschalten wird.
* Ein "Login mit PayPal" über einen PayPal Express Button im Warenkorb wird von diesem Modul nicht unterstützt, PayPal wird ganz normal wie andere Zahlungsarten auch bei der Auswahl der Zahlungsarten im Checkout angeboten.
* Für die Bestellung wird als Lieferadresse die vom Kunden im Shop angegebene Lieferadresse übergeben, es gibt daher keine Notwendigkeit mehr, den Kunden nach der Rückleitung von PayPal erneut nach seiner Lieferadresse zu fragen wie das bisher vom paypalwpp Modul der deutschen Zen Cart Version gehandhabt wurde.
* Dieses Modul unterstützt rein PayPal Wallet und Kreditkarte via PayPal.
* Apple Pay, Google Pay oder andere Zahlungsarten sind nicht enthalten. 
