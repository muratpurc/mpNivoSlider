CONTENIDO Nivo Slider Modul mpNivoSlider 0.3.0 für CONTENIDO 4.9.x

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
    <link rel="stylesheet" href="data/modules/mp_nivo_slider/vendor/nivo-slider/nivo-slider.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="data/modules/mp_nivo_slider/vendor/nivo-slider/themes/contenido/contenido.css" type="text/css" media="screen" />

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js" type="text/javascript"></script>
</head>
...
[/code]

Hinweis:
Die Nivo Slider JavaScript-Datei ist schom im Modul-Template eingebunden,
nicht im head-Bereich. Da muss man nichts machen, aber bei Bedarf kann man das auch
in den head-Bereich auslagern.
[code]
...
<script src="data/modules/mp_nivo_slider/vendor/nivo-slider/jquery.nivo.slider.pack.js" type="text/javascript"></script>
...
[/code]


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
cms/data/modules/mp_nivo_slider/vendor/nivo-slider/themes/) zur Verfügung.
Zum Konfigurieren eines anderen Themes, z. B. bar, folgendes befolgen:
Im head-Bereich die Zeile
[code]
    <link rel="stylesheet" href="data/modules/mp_nivo_slider/vendor/nivo-slider/themes/contenido/contenido.css" type="text/css" media="screen" />
[/code]
gegen 
[code]
    <link rel="stylesheet" href="data/modules/mp_nivo_slider/vendor/nivo-slider/themes/bar/bar.css" type="text/css" media="screen" />
[/code]
ersetzen.

Im Modultemplate (cms/data/modules/mp_nivo_slider/template/mpNivoSlider.html) die Zeile
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

Verwendung mit anderen JavaScript Frameworks:
---------------------------------------------
Das Nivo Slider Modul basiert auf jQuery und jQuery bietet eigentlich auch die Option 
"jQuery.noConflict();", um mit anderen JavaScript-Frameworks zusammen zu funktionieren.
Dies klappt nicht in Verbindung mit den Prototype.js Framework, es verursacht 
Konflikte unter IE und Opera.
Daher ist es ratsam, im Layout nur jQuery einzubinden.


################################################################################
CHANGELOG

2013-11-15 mpNivoSlider Modul 0.3.0 (für CONTENIDO 4.9.x)
    * Erste Veröffentlichung des mpNivoSlider Moduls für CONTENIDO 4.9.x


################################################################################
MPNIVOSLIDER MODUL THEMEN IM CONTENIDO FORUM

mpNivoSlider: Nivo Slider Image-Gallery Modul für CONTENIDO 4.9.x:
http://forum.contenido.org/viewtopic.php?f=89&t=34705


################################################################################
SCHLUSSBEMERKUNG

Benutzung des Moduls auf eigene Gefahr!

Murat Purc, murat@purc.de
