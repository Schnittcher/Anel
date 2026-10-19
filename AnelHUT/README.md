# AnelHUT
Mit dieser Instanz werden Anel-Geräte (zum Beispiel HUT) in IP-Symcon eingebunden. Sie legt Variablen für die Relais, optional für die IOs und die Gerätetemperatur sowie bei vorhandenem Sensor für Temperatur, Luftfeuchte und Helligkeit an. Angelegt wird sie normalerweise über den AnelDiscovery-Konfigurator.

## Inhaltsverzeichnis
- [AnelHUT](#anelhut)
  - [Inhaltsverzeichnis](#inhaltsverzeichnis)
  - [1. Konfiguration](#1-konfiguration)
  - [2. Variablen](#2-variablen)
  - [3. Funktionen](#3-funktionen)
  - [4. Spenden](#4-spenden)
  - [5. Lizenz](#5-lizenz)

## 1. Konfiguration

Feld | Beschreibung
------------ | ----------------
IP-Adresse | IP-Adresse des Anel-Geräts
Benutzername | Benutzername für das Webinterface des Geräts
Passwort | Passwort für das Webinterface des Geräts
IOs anlegen | Legt die IOs des Geräts als Variablen an
Gerätetemperatur anlegen | Legt die Temperatur des Geräts als Variable an

## 2. Variablen

Variable | Ident | Typ | Beschreibung
------------ | ------------ | ------------ | ----------------
Name aus dem Gerät | `Relay1` bis `Relay8` | Ja/Nein | Schaltet das Relais, steuerbar
Name aus dem Gerät | `IO1` bis `IO8` | Ja/Nein | Nur mit "IOs anlegen". Als Ausgang ein steuerbarer Schalter, als Eingang eine Anzeige (An/Aus)
Temperatur vom Gerät | `DeviceTemperature` | Kommazahl (°C) | Nur mit "Gerätetemperatur anlegen"
Sensor Temperatur | `SensorTemperature` | Kommazahl (°C) | Nur, wenn das Gerät einen Sensor meldet
Sensor Luftfeuchte | `SensorHumidity` | Kommazahl (%) | Nur, wenn das Gerät einen Sensor meldet
Sensor Helligkeit | `SensorBrightness` | Ganzzahl (Lux) | Nur, wenn das Gerät einen Sensor meldet

## 3. Funktionen
Keine öffentlichen Funktionen vorhanden.

## 4. Spenden
Dieses Modul ist für die nicht kommerzielle Nutzung kostenlos, Schenkungen als Unterstützung für den Autor werden hier akzeptiert:

[![PayPal](https://img.shields.io/badge/PayPal-Spenden-00457C?logo=paypal&logoColor=white&style=for-the-badge)](https://www.paypal.com/donate?hosted_button_id=EK4JRP87XLSHW) [![Amazon Wunschzettel](https://img.shields.io/badge/Amazon-Wunschzettel-FF9900?logo=amazon&logoColor=white&style=for-the-badge)](https://www.amazon.de/hz/wishlist/ls/3JVWED9SZMDPK?ref_=wl_share)

## 5. Lizenz

[CC BY-NC-SA 4.0](https://creativecommons.org/licenses/by-nc-sa/4.0/)
