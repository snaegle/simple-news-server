# Einfacher Newsserver

## Komponenten
- API realisiert mit Symfony, gebaut mit composer
- GUI realisiert mit Vuejs 3, API-Calls mit Axios, gebundled mit Vite
- Datenbank realisiert mit MySQL

## Requirements
- nvm oder npm 18
- docker
- docker-compose

## Starten
- nvm install
- ./start.sh

## Betriebsdokumentation
- API: http://localhost:8108
- GUI: http://localhost:8008
- PHPMyAdmin: http://localhost:8088

## Aufbau des GUI
- Hauptansicht (./): Hier werden alle News aufgelistet.
- Neue News erstellen (./new)
- News editieren: (./edit/<newsid>)
- News löschen: (./delete/<newsid>)

## Stolpersteine
- Ansprache des API vom GUI aus: \
  VueJs läuft außerhalb des Containers, daher muss die Route nicht localhost:80, sondern localhost:8108 sein
  Konfiguration in src/services/NewsService.js
- CORS \
  Die API muss CORS-Header akzeptieren \
  Konfiguration in symfony/config/packages/nelmio_cors.yaml
- Datumsauswahl \
  In der Datenbank ist das Datum der News als Unix-Timestamp gespeichert. Dieser ist die Anzahl von Sekunden seit dem 01. Januar 1970 definiert. \
  Es ist Usern allerdings nicht zuzumuten einen Timestamp zu sehen und einzugeben, daher muss dieser Timestamp umgewandelt werden, und zwar immer wenn aus der API gelesen und in die API geschrieben wird. \
  Dies muss außerdem in einem zurück konvertierbaren Format geschehen - daher der UTC-String, der in den Anzeigen dann ins deutsche Format verwandelt werden muss

## Bugs
Das Datum variiert um Minuten zwischen der Anzeige im Datepicker und dem dann tatsächlich verwendeten Datum.

## Nice to haves
- Eine Anzeige wie bei Twitter, wieviele Zeichen man noch zur Verfügung hat
- Eine Paginierung auf der Überssichtsseite
- Mehr Zeichen beim Inhalt. Würde man dies aktuell zulassen,   könnten die News den Rahmen sprengen, aber natürlich wären längere News wünschenswert. \
Daraus ergibt sich auch das nächste Nice to have:
- Eine Detailseite für News
- Es gibt eine Dopplung der Eingabeelemente für die News. Dies  sollte in eine Komponente ausgelagert werden
- Die Flash-Messages sollten in Komponenten ausgelagert werden
- Integrationtests
- Usertests
