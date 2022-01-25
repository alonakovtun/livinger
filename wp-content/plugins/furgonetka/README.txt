=== Furgonetka.pl: Integracja z WooCommerce ===
Contributors: Furgonetka
Donate link: https://furgonetka.pl
Tags: delivery, kurier, paczki, courier
Requires at least: 3.0.1
Tested up to: 5.5.5
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Integracja WooCommerce z Furgonetka.pl pozwoli Ci nadawać przesyłki sprawdzonymi przewoźnikami takimi jak DPD, DHL, UPS, InPost, GLS, Poczta Polska, FedEx, Meest, Ambro Express oraz Paczka w RUCHu.

== Description ==

Wtyczka pozwala na integrację z platformą usług kurierskich Furgonetka.pl. Za jej pośrednictwem można uzyskać dostęp do szerokiej oferty aż 10 firm kurierskich, bez konieczności podpisywania umowy. Wtyczka pozwala nadawać nawet duże ilości paczek bezpośrednio z panelu WooCommerce. Korzystając z niej, można zlecać odbiór paczek wybranym firmom kurierskim, automatycznie generować i drukować dokumenty przewozowe oraz udostępniać klientom w koszyku sklepu mapę z punktami nadawania i odbioru przesyłek. Dzięki niej można oszczędzić czas i zlecać wysyłkę zamówień do klientów o wiele taniej oraz szybciej.
Platformę Furgonetka wyróżnia:

* dostęp do oferty takich firm, jak DPD, DHL, UPS, InPost, FedEx, Paczkomaty, Poczta Polska, Paczka w RUCHu, GLS, Meest, Ambro Express,
* atrakcyjne ceny przesyłek, nawet do 70% tańsze od standardowych,
* brak ukrytych kosztów i opłata paliwowa w cenie,
* szeroki wachlarz usług - możliwość wysyłki kopert, paczek i palet; przesyłki krajowe i międzynarodowe, a także dostawy pod adres i do punktów odbioru,
* brak konieczności podpisywania umowy i deklaracji wolumenów.

https://youtu.be/rYiHkrhGCGw

Do korzystania z wtyczki Furgonetka WooCommerce wymagane jest posiadanie konta na [Furgonetka.pl](https://furgonetka.pl/rejestracja)

Wsparcie techniczne dla integracji:
Tel.: + 48 22 112 08 35 (kolejka nr 2)
E-mail: tech@furgonetka.pl

== Installation  ==

Zainstaluj wtyczkę w panelu administracyjnym WordPressa:

* Krok 1. Z menu wybierz [Wtyczki] i następnie [Dodaj nową]. Po wskazaniu pliku ".zip" potwierdź, klikając [Zainstaluj teraz], a wtyczka zostanie zaimplementowana.
* Krok 2. Po potwierdzeniu poprawnej instalacji wtyczki komunikatem: "Wtyczka została zainstalowana" należy ją włączyć, klikając przycisk [Włącz wtyczkę].
* Krok 3. Wgraną i włączoną wtyczkę należy jeszcze skonfigurować. W tym celu w bocznym menu przejdź do zainstalowanych wtyczek. Wybierz [Ustawienia] wtyczki Furgonetka.
* Krok 4. Aby wygenerować potrzebne do integracji klucze (klienta i prywatny), należy je utworzyć, klikając opcję [Stwórz nowy klucz]. Upewnij się, że dodajesz nowy klucz REST API w WooCommerce z uprawnieniami do odczytu. Pamiętaj skopiować swoje nowe klucze, ponieważ prywatny klucz zostanie ukryty kiedy opuścisz tę stronę.
* Krok 5. Wygenerowane klucze wpisz w pola z poprzedniego kroku i wybierz [Zapisz]. Wyraź zgodę na połączenie aplikacji z kontem na Furgonetka.pl.

== Frequently Asked Questions ===

= Czy plugin wyświetli mi mapę punktów w koszyku sklepu?
Tak. Wtyczka posiada opcję wyświetlenia mapy.

= Posiadanie konta na Furgonetka.pl jest wymagane?
Tak, aby korzystać z tej wtyczki, należy mieć utworzone konto na [Furgonetka.pl](https://furgonetka.pl/rejestracja).

== Screenshots ==

1. Rejestracja
2. Formularz
Integracja WooCommerce z kurierem Furgonetka.pl

== Changelog ==

1.0.0
* first version of plugin
1.0.1
* form fixes
1.0.2
* data validation
1.0.3
* attach js and css just on checkout page && WC 3.6.4 test
1.0.4
* fix for wp in catalog
1.0.5
* Fixed access token refreshing.
1.0.6
* Added maps for FedEx Punkt and DHL Parcel
* Added modified_after param to API orders method
* Renamed plugin to Furgonetka.pl
1.0.7
* subdomain fix
* validate point fix
* fix for properties access
* added Flexible Shipping plugin support
1.0.8
* Update of descriptions
1.0.9
* user reference number fix
* Fix for filtering orders by change date
* Fix for displaying delivery methods without assigned zone
* Start handling single flexible shipping methods, stop handling group flexible shipping methods

== Upgrade Notice ==

= 1.0.9 =
This version fixes a displaying flexible shipping methods bug.
