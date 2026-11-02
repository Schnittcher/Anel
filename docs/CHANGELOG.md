# Changelog

## 19.10.2026 - Version 2.0

### Neu
- Die Module benötigen jetzt IP-Symcon 9.0.
- Relais, IOs, Temperatur, Luftfeuchte und Helligkeit nutzen die neuen Darstellungen von IP-Symcon 9.
- Achtung: Bestehende Variablen bekommen die neue Darstellung, sobald das Gerät das nächste Mal Daten sendet. Eigene Anpassungen an der Darstellung bleiben erhalten.

### Fixes
- Daten vom Gerät und Schaltbefehle funktionieren wieder unter IP-Symcon 9.
- Achtung: Bei bestehenden Installationen im UDP Socket als "Sende-Host" die IP-Adresse eines Geräts eintragen, sonst können die Relais nicht geschaltet werden.
- Unvollständige Daten vom Gerät führen nicht mehr zu Fehlern im Log.
- Relais und IOs werden nur noch angelegt, wenn das Gerät sie meldet.
- Die Zugangsdaten stehen nicht mehr im Debug.
- Der Konfigurator zeigt die gefundenen Geräte wieder zuverlässig an.
- Der Dokumentationslink der Instanzen führt jetzt zur Dokumentation auf deinsmarthome.info.

## 01.09.2021 - Version 1.2.2

### Fixes
- Es gab Probleme, wenn Werte von einem Anel Gerät nicht gesendet wurden.

## 17.08.2020 - Version 1.2

### Neu
- IOs müssen nun aktiviert werden, wenn sie angezeigt werden sollen
- Gerätetemperatur muss nun aktiviert werden, wenn sie angezeigt werden soll

### Fixes
- Discovery Instanz überarbeitet

## 17.07.2020 - Version 1.1

### Neu
- Sensor hinzugefügt

## 23.01.2020 - Version 1.0.2 (Beta)

### Fixes
- Discovery

## 23.01.2020 - Version 1.0.1

### Fixes
- IOs

## 21.01.2020 - Version 1.0

### Neu
- Erste Version
