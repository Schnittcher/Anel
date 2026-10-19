[![Version](https://img.shields.io/badge/Symcon-PHPModul-red.svg)](https://www.symcon.de/service/dokumentation/entwicklerbereich/sdk-tools/sdk-php/)
![Version](https://img.shields.io/badge/Symcon%20Version-9.0%20%3E-blue.svg)
[![License](https://img.shields.io/badge/License-CC%20BY--NC--SA%204.0-green.svg)](https://creativecommons.org/licenses/by-nc-sa/4.0/)
[![Check Style](https://github.com/Schnittcher/Anel/actions/workflows/style.yml/badge.svg)](https://github.com/Schnittcher/Anel/actions/workflows/style.yml)
[![Tests](https://github.com/Schnittcher/Anel/actions/workflows/tests.yml/badge.svg)](https://github.com/Schnittcher/Anel/actions/workflows/tests.yml)

# Anel
Diese Bibliothek bindet Anel-Geräte mit Relais und IOs (zum Beispiel HUT) in IP-Symcon ein und findet sie per Discovery im Netzwerk.

## Inhaltsverzeichnis
- [Anel](#anel)
  - [Inhaltsverzeichnis](#inhaltsverzeichnis)
  - [1. Voraussetzungen](#1-voraussetzungen)
  - [2. Funktionsumfang](#2-funktionsumfang)
  - [3. Enthaltene Module](#3-enthaltene-module)
  - [4. Installation](#4-installation)
  - [5. Konfiguration in IP-Symcon](#5-konfiguration-in-ip-symcon)
  - [6. Spenden](#6-spenden)
  - [7. Lizenz](#7-lizenz)

## 1. Voraussetzungen

* mindestens IPS Version 9.0
* Anel-Gerät im selben Netzwerk, erreichbar per UDP (Ports 75 und 77)
* Benutzername und Passwort des Webinterfaces des Geräts

## 2. Funktionsumfang

* Anel-Geräte im Netzwerk finden und anlegen
* Relais und IOs schalten
* Gerätetemperatur und Sensorwerte (Temperatur, Luftfeuchte, Helligkeit) anzeigen

Die einzelnen Funktionen stehen bei den Instanzen unter "Enthaltene Module" und in der README des jeweiligen Moduls.

## 3. Enthaltene Module

* [AnelDiscovery](AnelDiscovery/README.md)
  * Findet Anel-Geräte im Netzwerk und legt AnelHUT-Instanzen an.
  * Übernimmt Benutzername und Passwort in die neuen Instanzen.
* [AnelHUT](AnelHUT/README.md)
  * Schaltet die Relais und IOs eines Anel-Geräts.
  * Zeigt Gerätetemperatur und Sensorwerte an.

## 4. Installation
Die Installation erfolgt über den IP-Symcon Module Store.

## 5. Konfiguration in IP-Symcon
Zuerst wird die Instanz AnelDiscovery angelegt, dort Benutzername und Passwort des Geräts eintragen. Der Konfigurator sucht die Geräte im Netzwerk und legt je Gerät eine AnelHUT-Instanz an. Die Felder der Instanzen stehen in den READMEs der Module.

Bei einer bestehenden Installation muss im UDP Socket als "Sende-Host" die IP-Adresse eines Geräts eingetragen sein, sonst können die Relais nicht geschaltet werden.

## 6. Spenden
Dieses Modul ist für die nicht kommerzielle Nutzung kostenlos, Schenkungen als Unterstützung für den Autor werden hier akzeptiert:

[![PayPal](https://img.shields.io/badge/PayPal-Spenden-00457C?logo=paypal&logoColor=white&style=for-the-badge)](https://www.paypal.com/donate?hosted_button_id=EK4JRP87XLSHW) [![Amazon Wunschzettel](https://img.shields.io/badge/Amazon-Wunschzettel-FF9900?logo=amazon&logoColor=white&style=for-the-badge)](https://www.amazon.de/hz/wishlist/ls/3JVWED9SZMDPK?ref_=wl_share)

## 7. Lizenz

[CC BY-NC-SA 4.0](https://creativecommons.org/licenses/by-nc-sa/4.0/)
