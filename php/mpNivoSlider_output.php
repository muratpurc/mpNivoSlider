<?php
/**
 * Module-Output: mpNivoSlider
 *
 * Based on Nivo Slider, a jQuery based image slider
 * See http://nivo.dev7studios.com/
 *
 * @package     CONTENIDO_Modules
 * @subpackage  mpNivoSlider
 * @author      Murat Purc <murat@purc.de>
 * @copyright   Copyright (c) 2011-2012 Murat Purc (http://www.purc.de)
 * @license     http://www.gnu.org/licenses/gpl-2.0.html - GNU General Public License, version 2
 * @version     $Id: mpNivoSlider_output.php 5 2012-09-07 19:22:49Z murat $
 */

cInclude('frontend', 'includes/functions.mpnivoslider.php');
cInclude('frontend', 'includes/class.module.mpnivoslider.output.php');
cInclude('classes', 'class.upload.php');
cInclude('frontend', 'includes/class.uploadmeta.php');
cInclude('includes', 'functions.api.images.php');

// module configuration
$aModuleConfiguration = array(
    'selectedDirname' => "CMS_VALUE[1]",
    'useSubdirectories' => "CMS_VALUE[2]",
    'maxImages' => "CMS_VALUE[3]",
    'maxWidth' => "CMS_VALUE[4]",
    'maxHeight' => "CMS_VALUE[5]",
    'maxCachetime' => "CMS_VALUE[6]",
    'selectedOrder' => "CMS_VALUE[7]",
    'darkImages' => "CMS_VALUE[33]",
    'imageQuality' => "CMS_VALUE[34]",

    // Nivo Slider specific configuration
    'effect' => "CMS_VALUE[8]",
    'slices' => "CMS_VALUE[9]",
    'boxCols' => "CMS_VALUE[10]",
    'boxRows' => "CMS_VALUE[11]",
    'animSpeed' => "CMS_VALUE[12]",
    'pauseTime' => "CMS_VALUE[13]",
    'startSlide' => "CMS_VALUE[14]",
    'directionNav' => "CMS_VALUE[15]",
    'controlNav' => "CMS_VALUE[17]",
    'controlNavThumbs' => "CMS_VALUE[18]",
    'controlNavThumbsWidthX' => "CMS_VALUE[20]",  // speacial treatment
    'controlNavThumbsHeightX' => "CMS_VALUE[21]", // speacial treatment
    'pauseOnHover' => "CMS_VALUE[23]",
    'manualAdvance' => "CMS_VALUE[24]",
    'prevText' => "CMS_VALUE[26]",
    'nextText' => "CMS_VALUE[27]",
    'beforeChange' => "CMS_VALUE[28]",
    'afterChange' => "CMS_VALUE[29]",
    'slideshowEnd' => "CMS_VALUE[30]",
    'lastSlide' => "CMS_VALUE[31]",
    'afterLoad' => "CMS_VALUE[32]",
);

// module translation
$aModuleTranslations = array(
    'random' => mi18n("Zuf&auml;llig"),
    'filename_asc' => mi18n("Dateiname aufsteigend"),
    'filename_desc' => mi18n("Dateiname absteigend"),
    'size_asc' => mi18n("Dateigr&ouml;&szlig;e aufsteigend"),
    'size_desc' => mi18n("Dateigr&ouml;&szlig;e absteigend"),
    'filetype_asc' => mi18n("Dateityp aufsteigend"),
    'filetype_desc' => mi18n("Dateityp absteigend"),
    'created_asc' => mi18n("Erstellungsdatum aufsteigend"),
    'created_esc' => mi18n("Erstellungsdatum absteigend"),
    'id_asc' => mi18n("Id aufsteigend"),
    'id_desc' => mi18n("Id absteigend"),
    '__select_folder__' => mi18n("-- Ordner ausw&auml;hlen --"),
    '__select_order__' => mi18n("-- Sortierung ausw&auml;hlen --"),
    'previous' => mi18n("zur&uuml;ck"),
    'next' => mi18n("vor"),
);

// create mpNivoSlider module instance
$oModule = new ModuleMpNivoSliderOutput($aModuleConfiguration, $aModuleTranslations, $client, $cfgClient[$client], $lang);

// generate the slider
$oModule->generateOutput();

// save memory
unset($oModule, $aModuleConfiguration, $aModuleTranslations);

?>