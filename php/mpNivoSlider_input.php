?><?php
/**
 * Module-Input: mpNivoSlider
 *
 * Based on Nivo Slider, a jQuery based image slider
 * See http://nivo.dev7studios.com/
 *
 * @package     CONTENIDO_Modules
 * @subpackage  mpNivoSlider
 * @author      Murat Purc <murat@purc.de>
 * @copyright   Copyright (c) 2011-2012 Murat Purc (http://www.purc.de)
 * @license     http://www.gnu.org/licenses/gpl-2.0.html - GNU General Public License, version 2
 * @version     $Id: mpNivoSlider_input.php 5 2012-09-07 19:22:49Z murat $
 */

cInclude('frontend', 'includes/functions.mpnivoslider.php');
cInclude('frontend', 'includes/class.module.mpnivoslider.input.php');
cInclude('classes', 'class.upload.php');

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
//echo "<pre>" . print_r($aModuleConfiguration, true) . "</pre>";

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
$oModule = new ModuleMpNivoSliderInput($aModuleConfiguration, $aModuleTranslations, $client);

?>

<!-- module mpNivoSlider -->
<table cellspacing="0" cellpadding="3" border="0">
<tr>
    <td valign="top" class="text_medium"><?php echo mi18n("Bilderordner f&uuml;r Nivo Slider w&auml;hlen:") ?></td>
    <td>
        <!-- selectedDirname -->
        <select name="CMS_VAR[1]" class="text_medium">
        <?php echo $oModule->generateDirSelectOptions() ?>
        </select><br />
        <small><?php echo mi18n("(Der ausgew&auml;hlte Ordner sollte nur Bilder enthalten)") ?></small><br />
        <br />
        <input type="checkbox" class="text_medium" name="CMS_VAR[2]" id="<?php echo $oModule->getIdValue('useSubdirectories') ?>" value="1"<?php echo $oModule->getCheckedAttribute('useSubdirectories') ?> />
		<label for="<?php echo $oModule->getIdValue('useSubdirectories') ?>"><?php echo mi18n("Vorhandene Unterordner auch verwenden") ?></label><br />
        <small><?php echo mi18n("(Alle Bilder auch in vorhandenen Unterordnen verwenden)") ?></small><br />
        <br />
    </td>
</tr>
<tr>
    <td valign="top" class="text_medium"><?php echo mi18n("Helligkeit der Bilder:") ?></td>
    <td class="text_medium">
        <input type="checkbox" class="text_medium" name="CMS_VAR[33]" id="<?php echo $oModule->getIdValue('darkImages') ?>" value="1"<?php echo $oModule->getCheckedAttribute('darkImages') ?> />
		<label for="<?php echo $oModule->getIdValue('darkImages') ?>"><?php echo mi18n("Die Bilder sind in der Regel dunkel") ?></label><br />
        <small><?php echo mi18n("(Bei dunklen Bildern werden helle Navigationspfeile und Bildunterschriften mit hellem Hintergrund ausgegeben, bei hellen Bildern umgekehrt)") ?></small><br />
        <br />
    </td>
</tr>
<tr>
    <td valign="top" class="text_medium"><?php echo mi18n("Maximale Anzahl der Bilder:") ?></td>
    <td class="text_medium">
        <input type="text" class="text_medium" name="CMS_VAR[3]" value="<?php echo $oModule->maxImages ?>" /><br />
        <small><?php echo mi18n("(Leer lassen, wenn alle Bilder im ausgew&auml;hlten Verzeichnis ausgegeben werden sollen)") ?></small><br />
        <br />
    </td>
</tr>
<tr>
    <td valign="top" class="text_medium"><?php echo mi18n("Maximale Breite der Bilder:") ?></td>
    <td class="text_medium">
        <input type="text" class="text_medium" name="CMS_VAR[4]" value="<?php echo $oModule->maxWidth ?>" /> <?php echo mi18n("Pixel") ?><br />
    </td>
</tr>
<tr>
    <td valign="top" class="text_medium"><?php echo mi18n("Maximale H&ouml;he der Bilder:") ?></td>
    <td class="text_medium">
        <input type="text" class="text_medium" name="CMS_VAR[5]" value="<?php echo $oModule->maxHeight ?>" /> <?php echo mi18n("Pixel") ?><br />
        <small><?php echo mi18n("(Sind Werte f&uuml;r maximale Breite und/oder H&ouml;he angegeben,<br />werden gro&szlig;e Bilder herunter gerechnet.)") ?></small><br />
        <br />
    </td>
</tr>
<tr>
    <td valign="top" class="text_medium"><?php echo mi18n("Qualit&auml;t der Bilder:") ?></td>
    <td class="text_medium">
        <input type="text" class="text_medium" name="CMS_VAR[34]" value="<?php echo $oModule->imageQuality ?>" /> %<br />
        <small><?php echo mi18n("(Qualit&auml;t f&uuml;r heruntergerechnete JPEG-Bilder.)") ?></small><br />
        <br />
    </td>
</tr>
<tr>
    <td valign="top" class="text_medium"><?php echo mi18n("Maximale Cachedauer der Bilder:") ?></td>
    <td class="text_medium">
        <input type="text" class="text_medium" name="CMS_VAR[6]" value="<?php echo $oModule->maxCachetime ?>" /> <?php echo mi18n("Minuten") ?><br />
        <small><?php echo mi18n("(Gilt nur f&uuml;r zu gro&szlig;e Bilder, die herunter gerechnet wurden. F&uuml;r unbegrenzte Dauer leer lassen.)") ?></small>
    </td>
</tr>
<tr>
    <td valign="top" class="text_medium"><?php echo mi18n("Sortierung der Bilder im Nivo Slider:") ?></td>
    <td>
        <select name="CMS_VAR[7]" class="text_medium">
        <?php echo $oModule->generateOrderSelectOptions() ?>
        </select><br />
        <br />
    </td>
</tr>
<tr>
    <td valign="top" colspan="2" class="text_medium">
        <hr /><br />
        <b><?php echo mi18n("JavaScript Einstellungen f&uuml;r jQuery Nivo Slider Plugin") ?></b>
    </td>
</tr>
<tr>
    <td valign="top" class="text_medium"><?php echo mi18n("Effekt") ?>:</td>
    <td class="text_medium">
        <input type="text" class="text_medium" name="CMS_VAR[8]" value="<?php echo $oModule->effect ?>" /> <small><?php echo mi18n("(Standardwert: 'random', Sets: 'fold,fade,sliceDown')") ?></small> <br />
        <?php
        $tmp = explode(',', ModuleMpNivoSliderInput::EFFECTS);
        $tmp2 = '';
        foreach ($tmp as $p => $v) {
            $tmp2 .= $v . ', ';
            if ($p > 0 && $p % 5 == 0) {
                $tmp2 .= '<br />';
            }
        }
        ?>
        <span style="text-decoration:underline"><?php echo mi18n("M&ouml;gliche Werte") ?>:</span><br />
        <?php echo $tmp2 ?>
        <?php
        unset($tmp, $tmp2);
        ?>
    </td>
</tr>
<tr>
    <td valign="top" class="text_medium"><?php echo mi18n("Anzahl der Slices") ?>:</td>
    <td class="text_medium">
        <input type="text" class="text_medium" name="CMS_VAR[9]" value="<?php echo $oModule->slices ?>" /> <small><?php echo mi18n("F&uuml;r Slice Animationen") ?></small>
    </td>
</tr>
<tr>
    <td valign="top" class="text_medium"><?php echo mi18n("Anzahl der Spalten") ?>:</td>
    <td class="text_medium">
        <input type="text" class="text_medium" name="CMS_VAR[10]" value="<?php echo $oModule->boxCols ?>" /> <small><?php echo mi18n("F&uuml;r Box Animationen") ?></small>
    </td>
</tr>
<tr>
    <td valign="top" class="text_medium"><?php echo mi18n("Anzahl der Reihen") ?>:</td>
    <td class="text_medium">
        <input type="text" class="text_medium" name="CMS_VAR[11]" value="<?php echo $oModule->boxRows ?>" /> <small><?php echo mi18n("F&uuml;r Box Animationen") ?></small>
    </td>
</tr>
<tr>
    <td valign="top" class="text_medium"><?php echo mi18n("Geschwindigkeit der Animation") ?>:</td>
    <td class="text_medium">
        <input type="text" class="text_medium" name="CMS_VAR[12]" value="<?php echo $oModule->animSpeed ?>" /> <?php echo mi18n("Millisekunden") ?> <br />
        <small><?php echo mi18n("(F&uuml;r den &Uuml;berblendeffekt)") ?></small>
    </td>
</tr>
<tr>
    <td valign="top" class="text_medium"><?php echo mi18n("Zeit zwischen zwei Slides") ?>:</td>
    <td class="text_medium">
        <input type="text" class="text_medium" name="CMS_VAR[13]" value="<?php echo $oModule->pauseTime ?>" /> <?php echo mi18n("Millisekunden") ?> <br />
    </td>
</tr>
<tr>
    <td valign="top" class="text_medium"><?php echo mi18n("Startposition") ?>:</td>
    <td class="text_medium">
        <input type="text" class="text_medium" name="CMS_VAR[14]" value="<?php echo $oModule->startSlide ?>" /> <?php echo mi18n("0 (index)") ?> <br />
        <small><?php echo mi18n("(Beginn mit der Slideposition)") ?></small>
    </td>
</tr>
<!-- navigation -->
<tr>
    <td valign="top" class="text_medium"><?php echo mi18n("Navigation") ?>:</td>
    <td class="text_medium">
        <input type="checkbox" class="text_medium" name="CMS_VAR[15]" id="<?php echo $oModule->getIdValue('directionNav') ?>" value="1"<?php echo $oModule->getCheckedAttribute('directionNav') ?> />
		<label for="<?php echo $oModule->getIdValue('directionNav') ?>"><?php echo mi18n("Navigation aktivieren (vor und zur&uuml;ck)") ?></label><br />
        <br />
        <input type="text" class="text_medium" name="CMS_VAR[26]" value="<?php echo $oModule->prevText ?>" /> <?php echo mi18n("Text f&uuml;r vorheriges Element") ?><br />
        <br />
        <input type="text" class="text_medium" name="CMS_VAR[27]" value="<?php echo $oModule->nextText ?>" /> <?php echo mi18n("Text f&uuml;r n&auml;chstes Element") ?><br />
        <br />
    </td>
</tr>
<tr>
    <td valign="top" class="text_medium"><?php echo mi18n("Erweiterte Navigation") ?>:</td>
    <td class="text_medium">
        <input type="checkbox" class="text_medium" name="CMS_VAR[17]" id="<?php echo $oModule->getIdValue('controlNav') ?>" value="1"<?php echo $oModule->getCheckedAttribute('controlNav') ?> />
		<label for="<?php echo $oModule->getIdValue('controlNav') ?>"><?php echo mi18n("Erweiterte Navigation aktivieren (Steuerung &uuml;ber grafische Listenpunkte)") ?></label><br />
        <br />
        <div style="padding-left:20px;">
			<input type="checkbox" class="text_medium" name="CMS_VAR[18]" id="<?php echo $oModule->getIdValue('controlNavThumbs') ?>" value="1"<?php echo $oModule->getCheckedAttribute('controlNavThumbs') ?> />
			<label for="<?php echo $oModule->getIdValue('controlNavThumbs') ?>"><?php echo mi18n("Verwende Thumbnails f&uuml;r die erweiterte Navigation") ?></label><br />
		</div>
        <br />
        <input type="text" class="text_medium" name="CMS_VAR[20]" value="<?php echo $oModule->controlNavThumbsWidthX ?>" /> <?php echo mi18n("Thumbnailbreite in Pixel") ?><br />
        <br />
        <input type="text" class="text_medium" name="CMS_VAR[21]" value="<?php echo $oModule->controlNavThumbsHeightX ?>" /> <?php echo mi18n("Thumbnailh&ouml;he in Pixel") ?><br />
    </td>
</tr>
<tr>
    <td valign="top" class="text_medium"><?php echo mi18n("Anhalten bei mouseover") ?>:</td>
    <td class="text_medium">
        <input type="checkbox" class="text_medium" name="CMS_VAR[23]" id="<?php echo $oModule->getIdValue('pauseOnHover') ?>" value="1"<?php echo $oModule->getCheckedAttribute('pauseOnHover') ?> />
		<label for="<?php echo $oModule->getIdValue('pauseOnHover') ?>"><?php echo mi18n("Animationen bei mouseover anhalten") ?></label><br />
        <br />
    </td>
</tr>
<tr>
    <td valign="top" class="text_medium"><?php echo mi18n("Manuelle Slides") ?>:</td>
    <td class="text_medium">
        <input type="checkbox" class="text_medium" name="CMS_VAR[24]" id="<?php echo $oModule->getIdValue('manualAdvance') ?>" value="1"<?php echo $oModule->getCheckedAttribute('manualAdvance') ?> />
		<label for="<?php echo $oModule->getIdValue('manualAdvance') ?>"><?php echo mi18n("Manuelle &Uuml;berblendeffekte erzwingen") ?></label><br />
        <br />
    </td>
</tr>
<!-- javascript event handler -->
<tr>
    <td valign="top" colspan="2" class="text_medium"><b><?php echo mi18n("JavaScript Code f&uuml;r Nivo Slider Events") ?></b></td>
</tr>
<tr>
    <td valign="top" class="text_medium"><?php echo mi18n("on beforeChange") ?>:</td>
    <td class="text_medium">
        <?php echo '<textarea name="CMS_VAR[28]" cols="80" rows="2" style="width:350;font-family:monospace;">' . $oModule->beforeChange . '</textarea>'; ?>
        <?php echo mi18n("Wird vor dem Slide ausgel&ouml;st") ?>
        <br />
    </td>
</tr>
<tr>
    <td valign="top" class="text_medium"><?php echo mi18n("on afterChange") ?>:</td>
    <td class="text_medium">
        <?php echo '<textarea name="CMS_VAR[29]" cols="80" rows="2" style="width:350;font-family:monospace;">' . $oModule->afterChange . '</textarea>'; ?>
        <?php echo mi18n("Wird nach dem Slide ausgel&ouml;st") ?>
        <br />
    </td>
</tr>
<tr>
    <td valign="top" class="text_medium"><?php echo mi18n("on slideshowEnd") ?>:</td>
    <td class="text_medium">
        <?php echo '<textarea name="CMS_VAR[30]" cols="80" rows="2" style="width:350;font-family:monospace;">' . $oModule->slideshowEnd . '</textarea>'; ?>
        <?php echo mi18n("Wird ausgel&ouml;st nachdem alle Slides gezeigt wurden") ?>
        <br />
    </td>
</tr>
<tr>
    <td valign="top" class="text_medium"><?php echo mi18n("on lastSlide") ?>:</td>
    <td class="text_medium">
        <?php echo '<textarea name="CMS_VAR[31]" cols="80" rows="2" style="width:350;font-family:monospace;">' . $oModule->lastSlide . '</textarea>'; ?>
        <?php echo mi18n("Wird ausgel&ouml;st wenn der letzte Slide angezeigt wird") ?>
        <br />
    </td>
</tr>
<tr>
    <td valign="top" class="text_medium"><?php echo mi18n("on afterLoad") ?>:</td>
    <td class="text_medium">
        <?php echo '<textarea name="CMS_VAR[32]" cols="80" rows="2" style="width:350;font-family:monospace;">' . $oModule->afterLoad . '</textarea>'; ?>
        <?php echo mi18n("Wird ausgel&ouml;st nachdem der Nivo Slider geladen wurde") ?>
        <br />
    </td>
</tr>
</table>
<!-- /module mpNivoSlider -->

<?php

unset($oModule, $aModuleConfiguration, $aModuleTranslations);