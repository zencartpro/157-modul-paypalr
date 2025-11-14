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

# Voraussetzung
* Seit Version 1.3.0 setzt dieses Modul folgendes Update voraus:
* Plugin Manager Update 1.2.0 für Zen Cart 1.5.7j deutsch
* https://www.zen-cart-pro.at/knowledgebase/plugin-manager-update-fuer-zen-cart-1-5-7j-deutsch/
* Stellen Sie sicher, dass Sie Ihren 1.5.7j Shop mit diesem Update aktualisiert haben, bevor Sie Version 1.3.0 des paypalr Moduls installieren

# Features
* Zahlungen können nur autorisiert oder sofort eingezogen werden.
* Zahlungen können bei Bedarf via Shopadministration rückerstattet werden (ähnlich wie bei der PayPal Express Integration)
* komplette Sandbox Unterstützung, so dass alles im Sandbox Modus getestet werden kann
* Direkte Kreditkartenzahlung via PayPal optional aktivierbar, ohne dass der Kunde dazu ein PayPal Konto haben muss.
* Standardmäßig wird bei Kreditkartenzahlung die Strong Customer Authentication (SCA) nur abgefragt, wenn sie für die jeweilige Zahlung vorgesehen ist. Optional kann für jede Kreditkartentransaktion 3D Secure erzwungen werden.
* Dieses Modul liefert ein geändertes paypalwpp Modul mit, so dass das alte paypalwpp Modul nicht deaktiviert oder deinstalliert werden muss. Es bekommt den neuen Status "Retired". Dadurch wird es im Shop für die Kunden nicht mehr angeboten. Bestellungen, die früher via paypalwpp erfolgt sind können aber weiterhin via Shopadministration zurückerstattet werden.

# Anleitung zur Installation und Konfiguration
* https://paypalcheckout.zen-cart-pro.at

