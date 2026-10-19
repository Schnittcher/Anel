# Changelog

## 18.10.2026 - Version 1.3

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
