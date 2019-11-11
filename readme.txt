CONTENIDO Nivo Slider Modul mpNivoSlider 0.2 für CONTENIDO 4.8.x

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
Nivo Slider (v3.1) ist ein Image-Slider basierend auf jQuery, mit vielen Features 
wie Effekte, Tastatursteuerung, Verlinkung von Bildern, Themes, diverse Einstellungen, 
usw.

Benötigt jQuery v1.4+ und unterstützt folgende Browser:
Internet Explorer v7+, Firefox v3+, Google Chrome v4+, Safari v4+, Opera v10+

Webseite von Nivo Slider:
http://nivo.dev7studios.com/


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


1.) cms/includes/*:
-------------------
- class.module.mpnivoslider.input.php (Klasse für Nivo Slider Moduleingabe)
- class.module.mpnivoslider.output.php (Klasse für Nivo Slider Modulausgabe)
- class.module.mpnivoslider.php (Klasse für Nivo Slider Module)
- class.uploadmeta.php (GenericDB Klassen für Zugriff auf die Upload-Meta Tabelle)

Sind in das Verzeichnis "cms/includes/" zu kopieren.


2.) cms/js/*:
---------------
Enthält die Sourcen (JavaScript, CSS und Bilder) des Nivo Sliders.
Der Ordner "nivo-slider" in das Verzeichnis "cms/js/" zu kopieren.


3.) cms/templates/mpNivoSlider.html:
------------------------------------
Das Template für die Ausgabe, ist in das Verzeichnis "cms/templates/" zu kopieren.
Hinweis:
Die Nivo Slider JavaScript-Datei wird im Modul-Template eingebunden, nicht im head-Bereich.
[code]
...
<script src="js/nivo-slider/jquery.nivo.slider.pack.js" type="text/javascript"></script>
...
[/code]


4.) Einbinden der JS- und CSS-Dateien:
--------------------------------------
Die JavaScript- und CSS-Dateien des Moduls sind im head-Bereich des Layouts 
einzubinden:

Beispiel:
[code]
...
<head>
    <link rel="stylesheet" href="js/nivo-slider/nivo-slider.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="js/nivo-slider/themes/contenido/contenido.css" type="text/css" media="screen" />

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js" type="text/javascript"></script>
</head>
...
[/code]


5.) mpNivoSlider.xml:
---------------------
XML-Export des mpNivoSlider Moduls, ist über das CONTENIDO-Backend als Modul zu importieren.


7.) mpnivoslider_deutsch.xml:
-----------------------------
XML-Export der deutschen Modulübersetzung, ist über das CONTENIDO-Backend als 
Modulübersetzung zu importieren.


8.) mpnivoslider_english.xml:
-----------------------------
XML-Export der englischen Modulübersetzung, ist über das CONTENIDO-Backend als 
Modulübersetzung zu importieren.


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
("bar", "dark", "default" und "light", siehe cms/js/nivo-slider/themes/) zur Verfügung.
Zum Konfigurieren eines anderen Themes, z. B. bar, folgendes befolgen:
Im head-Bereich die Zeile
[code]
    <link rel="stylesheet" href="js/nivo-slider/themes/contenido/contenido.css" type="text/css" media="screen" />
[/code]
gegen 
[code]
    <link rel="stylesheet" href="js/nivo-slider/themes/bar/bar.css" type="text/css" media="screen" />
[/code]
ersetzen.

Im Modultemplate (cms/templates/mpNivoSlider.html) die Zeile
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
damit die neuen Bilder im Frontend angezeigt werden.

Anzahl der Bilder:
------------------
Das Modul ist nicht darauf ausgelegt, eine große Anzahl von Bildern im Slider zu verwalten.
Je mehr Bilder angezeigt werden sollen, desto länger dauert die Initialisierung des Sliders.
Maximal 10 Bilder sind ein guter Wert für die obere Grenze.

Verwendung mit anderen JavaScript Frameworks:
---------------------------------------------
Das Nivo Slider Modul basiert auf jQuery und jQuery bietet eigentlich auch die Option 
"jQuery.noConflict();", um mit anderen JavaScript-Frameworks zusammen zu funktionieren.
Dies klappt nicht in Verbindung mit den Prototype.js Framework, es verursacht 
Konflikte unter IE und Opera.
Daher ist es ratsam, im Layout nur jQuery einzubinden.


################################################################################
CHANGELOG

2012-09-07 mpNivoSlider Modul 0.2
    * new: Update auf Nivo Slider v3.1
    * new: Konfiguration für die Qualität von generierten JPEG-Bildern
    * new: json_decode() implementation in PHP falls json_decode nicht verfügbar ist
    * change: jQuery Nivo Slider Plugins im separaten Scope um Probleme mit anderen
	  JS-Frameworks zu vermeiden
    * change: Entfernen diverser Nivo Slider Optionen,
	  siehe http://nivo.dev7studios.com/2012/05/30/the-nivo-slider-is-responsive/

2011-11-22 mpNivoSlider Modul 0.13rc
    * new: Erweitert auf mehrfachen Einsatz innerhalb einer Seite
    * bugfix: Sprachabhängige Bildbeschreibung auslesen
    * bugfix: Englische Modulübersetzung korrigiert

2011-09-28 mpNivoSlider Modul 0.1rc
    * Erste Veröffentlichung des mpNivoSlider Moduls


################################################################################
MPNIVOSLIDER MODUL THEMEN IM CONTENIDO FORUM

mpNivoSlider: Nivo Slider Image-Gallery Modul für CONTENIDO 4.8:
http://forum.contenido.org/viewtopic.php?f=60&t=31601


################################################################################
SCHLUSSBEMERKUNG

Benutzung des Moduls auf eigene Gefahr!

Murat Purc, murat@purc.de
