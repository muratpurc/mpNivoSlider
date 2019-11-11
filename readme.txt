CONTENIDO Nivo Slider Modul mpNivoSlider 0.1rc für CONTENIDO 4.8.x

################################################################################
TOC (Table of contents)

- BESCHREIBUNG
- INSTALLATION
- TIPPS&TRICKS
- CHANGELOG
- MPNIVOSLIDER MODUL THEMEN IM CONTENIDO FORUM
- SCHLUSSBEMERKUNG


################################################################################
BESCHREIBUNG

Nivo Slider:
------------
Nivo Slider (v2.6) ist ein Image-Slider basierend auf jQuery, mit vielen Features 
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


4.) Einbinden der JS- und CSS-Dateien:
--------------------------------------
Die JavaScript- und CSS-Dateien des Moduls sind im head-Bereich des Layouts 
einzubinden:

Beispiel:
[code]
...
<head>
    <link rel="stylesheet" href="js/nivo-slider/nivo-slider.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="js/nivo-slider/themes/default/default.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="js/nivo-slider/mpNivoSlider.css" type="text/css" media="screen" />

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript"></script>
    <script src="js/nivo-slider/jquery.nivo.slider.pack.js" type="text/javascript"></script>
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
TIPPS&TRICKS

Bildergrößen:
-------------
Die Proportionen der Bilder, das Verhältnis zwischen Breite und Höhe der Bilder, 
im gewählten Bilderordner sollten alle gleich sein. Das Modul rechnet zwar Bilder
auf die Angegebenen Bildmaße herunter, aber eine Mischung aus verschiedenen 
Proportionen (4:3 und 16:9) erzeugt Bilder, die nicht alle die vorhandene Breite
und Höhe der Slides füllt.

Anzahl der Thumbnails:
----------------------
Wenn Anzeige der Thumbnails aktiviert ist, sollte die Breite der Thumbnails so 
angepasst werden, dass alle in eine Zeile passen. Mehrzeilige Thumbnail-Liste wird
nicht unterstützt.

Themes:
-------
Als Standard wird das Theme "default" verwendet. Es stehen auch weitere Themes
("orman" und "pascal", siehe cms/js/nivo-slider/themes/) zur Verfügung. Zum 
Konfigurieren eines anderen Themes, z. B. orman, folgendes befolgen:
Im head-Bereich die Zeile
[code]
    <link rel="stylesheet" href="js/nivo-slider/themes/default/default.css" type="text/css" media="screen" />
[/code]
gegen 
[code]
    <link rel="stylesheet" href="js/nivo-slider/themes/orman/orman.css" type="text/css" media="screen" />
[/code]
ersetzen.

Im Modultemplate (cms/templates/mpNivoSlider.html) die Zeile
[code]
    <div class="slider-wrapper theme-default">
[/code]
gegen 
[code]
    <div class="slider-wrapper theme-orman">
[/code]
ersetzen.

Gegebenenfalls CSS-Formate in der cms/js/nivo-slider/mpNivoSlider.css für das 
neue Theme anpassen/erweitern.


Verwendung mit anderen JavaScript Frameworks:
---------------------------------------------
Das Nivo Slider Modul basiert auf jQuery und jQuery bietet eigentlich auch die Option 
"jQuery.noConflict();", um mit anderen JavaScript-Frameworks zusammen zu funktionieren.
Dies klappt nicht in Verbindung mit den Prototype.js Framework, es verursacht 
Konflikte unter IE und Opera.
Daher ist es ratsam, im Layout nur jQuery einzubinden.


################################################################################
CHANGELOG

2011-09-28 mpNivoSlider Modul 0.1.rc
    * Erste Veröffentlichung des mpNivoSlider Moduls.


################################################################################
MPNIVOSLIDER MODUL THEMEN IM CONTENIDO FORUM

@todo


################################################################################
SCHLUSSBEMERKUNG

Benutzung des Moduls auf eigene Gefahr!

Murat Purc, murat@purc.de
