CONTENIDO CMS Nivo Slider Modul mpNivoSlider zum Generieren eines Image-Sliders

################################################################################
TOC (Table of contents)

- BESCHREIBUNG
- INSTALLATION
- TIPPS & TRICKS
- CHANGELOG
- MPNIVOSLIDER MODUL THEMEN IM CONTENIDO FORUM
- SCHLUSSBEMERKUNG


################################################################################
BESCHREIBUNG

Nivo Slider:
------------
Nivo Slider (v3.2) ist ein Image-Slider basierend auf jQuery, mit vielen Features
wie Effekte, Tastatursteuerung, Verlinkung von Bildern, Themes, diverse Einstellungen,
usw.

Benötigt jQuery v1.7+ und unterstützt folgende Browser:
Internet Explorer v7+, Firefox v3+, Google Chrome v4+, Safari v4+, Opera v10+

Webseite von Nivo Slider:
https://themeisle.com/plugins/nivo-slider/ (ehemals http://nivo.dev7studios.com/)


CONTENIDO Modul:
----------------
Das Modul bietet diverse Einstellungsmöglichkeiten zur Steuerung des Nivo Sliders.
Unterstützt die Bildformate jpg, jpeg, png, und gif. Die Skalierung der Bilder
ist von der installierten GD-Library oder ImageMagick abhängig.

Konfigurationsmöglichkeiten des Moduls:
* Auswahl des Bilderordners innerhalb des upload-Verzeichnisses des Mandanten
* Verwendung von Bildern auch in Unterordnern
* Cachedauer für skalierte Bilder
* Viele Nivo Slider Optionen.


################################################################################
INSTALLATION

Die im Modulpackage enthaltenen Dateien/Sourcen sind wie im Folgenden beschrieben
zu installieren.
Die Pfade zu den Sourcen (CSS, JS und Templates) können von Projekt zu Projekt
unterschiedlich sein und sind bei Bedarf anzupassen.
Bei der Installationsbeschreibung wird davon ausgegangen, dass CONTENIDO in das
DocumentRoot-Verzeichnis eines Webservers installiert wurde und das
Mandantenverzeichnis "cms/" ist.

1.) Modul
Den Modulordner "mp_nivo_slider" samt aller Inhalte in das Modulverzeichnis des
Mandanten "cms/data/modules" kopieren.


2.) Einbinden der JS- und CSS-Dateien:
--------------------------------------
Die JavaScript- und CSS-Dateien des Moduls sind im head-Bereich des Layouts
einzubinden:

Beispiel:
[code]
...
<head>
    <link rel="stylesheet" href="data/modules/mp_nivo_slider/lib/nivo-slider/nivo-slider.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="data/modules/mp_nivo_slider/lib/nivo-slider/themes/contenido/contenido.css" type="text/css" media="screen" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js" type="text/javascript"></script>
</head>
...
[/code]

Hinweise:
Die Nivo Slider JavaScript-Datei ist schon im Modul-Template eingebunden,
nicht im head-Bereich. Da muss man nichts machen, aber bei Bedarf kann man das auch
in den head-Bereich oder vor dem schließenden body-Tag (</body>) auslagern.
[code]
...
<script src="data/modules/mp_nivo_slider/lib/nivo-slider/jquery.nivo.slider.pack.js" type="text/javascript"></script>
...
[/code]

Beim Einbinden der JavaScript-Dateien muss man auf die Reihenfolge acht geben,
die sollte wie folgt sein:
- jQuery (jquery.min.js)
- Nivo Slider JavaScript-Datei (jquery.nivo.slider.pack.js)
- JavaScript-Code im Modul-Template, das den Slider initialisiert


################################################################################
TIPPS & TRICKS

Bildergrößen:
-------------
Die Proportionen der Bilder, das Verhältnis zwischen Breite und Höhe der Bilder,
im gewählten Bilderordner sollten alle gleich sein. Das Modul rechnet zwar Bilder
auf die Angegebenen Bildmaße herunter, aber eine Mischung aus verschiedenen
Proportionen (4:3 und 16:9) erzeugt Bilder, die nicht alle die vorhandene Breite
und Höhe der Slides füllt.

Anzahl der Thumbnails:
----------------------
Wenn Anzeige der Thumbnails aktiviert ist, und die Liste der Thumbnails nicht in eine
Zeile passen, werden die Thumbnails in mehreren Zeilen dargestellt.

Themes:
-------
Als Standard wird das Theme "contenido" verwendet. Es stehen auch weitere Themes
("bar", "dark", "default" und "light", siehe
cms/data/modules/mp_nivo_slider/lib/nivo-slider/themes/) zur Verfügung.
Zum Konfigurieren eines anderen Themes, z. B. bar, folgendes befolgen:
Im head-Bereich die Zeile
[code]
    <link rel="stylesheet" href="data/modules/mp_nivo_slider/lib/nivo-slider/themes/contenido/contenido.css" type="text/css" media="screen" />
[/code]
gegen
[code]
    <link rel="stylesheet" href="data/modules/mp_nivo_slider/lib/nivo-slider/themes/bar/bar.css" type="text/css" media="screen" />
[/code]
ersetzen.

Im Modultemplate (cms/data/modules/mp_nivo_slider/template/get.tpl) die Zeile
[code]
    <div class="slider-wrapper theme-contenido">
[/code]
gegen
[code]
    <div class="slider-wrapper theme-bar">
[/code]
ersetzen.

Gegebenenfalls CSS-Formate für das neue Theme anpassen/erweitern.

FTP-Upload:
-----------
Das Modul liest Bildinformationen aus der Upload Datenbank-Tabelle aus, nicht aus dem
Upload Verzeichnis. Wenn Bilder per FTP auf den Server übertragen wurden, sollte das
entsprechende Uploadverzeichnis im Backend unter Dateiverwaltung synchronisiert werden,
damit das Modul die neuen Bilder im Frontend anzeigen kann.

Anzahl der Bilder:
------------------
Das Modul ist nicht darauf ausgelegt, eine große Anzahl von Bildern im Slider zu verwalten.
Je mehr Bilder angezeigt werden sollen, desto länger dauert die Initialisierung des Sliders.
Maximal 10 Bilder sind ein guter Wert für die obere Grenze.

Ausgeben der JavaScript-Sourcen am Ende der Seite:
--------------------------------------------------
Idealerweise sollten JavaScript-Dateien am Ende der Seite ausgegeben werden,
damit das Laden von JavaScript die initiale Anzeige der Seite nicht allzu sehr
verzögert.
Man kann die Nivo Slider JavaScript-Datei auch vor dem schließenden body-Tag
(</body>) einbinden. Danach sollte der JavaScript-Code im Modul-Template, das
den Nivo-Slider initialisiert, ausgegeben werden.
Um das zu realisieren, kann man die Ausgabe des JavaScript Codes zum Initialisieren
des Sliders in einer Variable speichern, um es am Ende der Seite in einem
Modul auszugeben. In Smarty kann man z. B. mit "capture" die Ausgabe speichern,
um es später auszugeben.


################################################################################
CHANGELOG

2019-11-15 mpNivoSlider Modul 0.4.0 (für CONTENIDO 4.9.x - 4.10.x)
    * change: Quellcode überarbeitet
    * change: Support für PHP < 5.2 entfernt
    * change: Modul-Template in ein Smarty-Template portiert
    * change: Ordner "vendor" in "lib" umbenannt

2013-03-23 mpNivoSlider Modul 0.3.0 (für CONTENIDO 4.8.x)
    * new: Update auf Nivo Slider v3.2
    * new: Responsive Modus integriert
    * bugfix: Kleine Bilder nicht hochskalieren

2013-03-23 mpNivoSlider Modul 0.2.1 (für CONTENIDO 4.8.x)
    * bugfix: Fehler bei der Ausgabe der Sortierung korrigiert

2012-09-07 mpNivoSlider Modul 0.2 (für CONTENIDO 4.8.x)
    * new: Update auf Nivo Slider v3.1
    * new: Konfiguration für die Qualität von generierten JPEG-Bildern
    * new: json_decode() implementation in PHP falls json_decode nicht verfügbar ist
    * change: jQuery Nivo Slider Plugins im separaten Scope um Probleme mit anderen
	  JS-Frameworks zu vermeiden
    * change: Entfernen diverser Nivo Slider Optionen,
	  siehe https://nivo.dev7studios.com/2012/05/30/the-nivo-slider-is-responsive/

2011-11-22 mpNivoSlider Modul 0.13rc (für CONTENIDO 4.8.x)
    * new: Erweitert auf mehrfachen Einsatz innerhalb einer Seite
    * bugfix: Sprachabhängige Bildbeschreibung auslesen
    * bugfix: Englische Modulübersetzung korrigiert

2011-09-28 mpNivoSlider Modul 0.1rc (für CONTENIDO 4.8.x)
    * Erste Veröffentlichung des mpNivoSlider Moduls


################################################################################
MPNIVOSLIDER MODUL LINKS

CONTENIDO Forum unter "CONTENIDO 4.10 -> Module und Plugins":
https://forum.contenido.org/viewtopic.php?t=43782

CONTENIDO Forum unter "CONTENIDO 4.9 -> Module und Plugins":
https://forum.contenido.org/viewtopic.php?t=34705

CONTENIDO Forum unter "CONTENIDO 4.8 -> Module und Plugins":
https://forum.contenido.org/viewtopic.php?t=31601


################################################################################
SCHLUSSBEMERKUNG

Benutzung des Moduls auf eigene Gefahr!

Murat Purç, murat@purc.de
