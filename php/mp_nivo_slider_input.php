?><?php
/**
 * Module-Input: mpNivoSlider
 *
 * Based on Nivo Slider, a jQuery based image slider
 * See http://nivo.dev7studios.com/
 *
 * @package     CONTENIDO_Modules
 * @subpackage  mpNivoSlider
 * @author      Murat Purç <murat@purc.de>
 * @copyright   Murat Purç (https://www.purc.de)
 * @license     http://www.gnu.org/licenses/gpl-2.0.html - GNU General Public License, version 2
 */

/**
 * @var int $cCurrentModule
 * @var int $cCurrentContainer
 */

(function() {

    global $cCurrentModule, $cCurrentContainer;

    // Includes
    if (!class_exists(Purc\Module\MpNivoSlider\Input::class)) {
        cInclude('module', 'includes/functions.mpnivoslider.php');
        cInclude('module', 'includes/class.module.mpnivoslider.input.php');
    }

    // Create mpNivoSlider module instance
    $module = new Purc\Module\MpNivoSlider\Input([
        'name' => 'mpNivoSlider',
        'idmod' => $cCurrentModule,
        'container' => $cCurrentContainer,
        'isBackend' => cSecurity::toBoolean(cRegistry::getBackendSessionId()),
        'clientCfg' => cRegistry::getClientConfig(cRegistry::getClientId()),
        'client' => cRegistry::getClientId(),
        'lang' => cRegistry::getLanguageId(),

        'selectedDirname' => "CMS_VALUE[1]",
        'useSubdirectories' => "CMS_VALUE[2]",
        'maxImages' => "CMS_VALUE[3]",
        'maxWidth' => "CMS_VALUE[4]",
        'maxHeight' => "CMS_VALUE[5]",
        'maxCacheTime' => "CMS_VALUE[6]",
        'selectedOrder' => "CMS_VALUE[7]",
        'darkImages' => "CMS_VALUE[33]",
        'imageQuality' => "CMS_VALUE[34]",
        'responsiveMode' => "CMS_VALUE[35]",

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
        'controlNavThumbsWidthX' => "CMS_VALUE[20]",  // Special treatment
        'controlNavThumbsHeightX' => "CMS_VALUE[21]", // Special treatment
        'pauseOnHover' => "CMS_VALUE[23]",
        'manualAdvance' => "CMS_VALUE[24]",
        'prevText' => "CMS_VALUE[26]",
        'nextText' => "CMS_VALUE[27]",
        'beforeChange' => "CMS_VALUE[28]",
        'afterChange' => "CMS_VALUE[29]",
        'slideshowEnd' => "CMS_VALUE[30]",
        'lastSlide' => "CMS_VALUE[31]",
        'afterLoad' => "CMS_VALUE[32]",

        'i18n' => \Purc\Module\MpNivoSlider\getModuleTranslations(),
    ]);

    ?>

    <!-- module mpNivoSlider -->
    <table class="generic">
        <tr>
            <td class="vgtop text_medium"><?php echo mi18n("MSG_SELECT_IMAGE_FOLDER") ?></td>
            <td>
                <!-- selectedDirname -->
                <select name="CMS_VAR[1]" class="text_medium" aria-label="<?php echo mi18n("MSG_SELECT_IMAGE_FOLDER") ?>">
                    <?php echo $module->generateDirSelectOptions() ?>
                </select><br />
                <small><?php echo mi18n("INFO_SELECT_IMAGE_FOLDER") ?></small><br />
                <br />
                <input type="checkbox" class="text_medium" name="CMS_VAR[2]" id="<?php echo $module->getIdValue('useSubdirectories') ?>" value="1"<?php echo $module->getCheckedAttribute('useSubdirectories') ?> />
                <label for="<?php echo $module->getIdValue('useSubdirectories') ?>"><?php echo mi18n("MSG_USE_SUBDIRS") ?></label><br />
                <small><?php echo mi18n("INFO_USE_SUBDIRS") ?></small><br />
                <br />
            </td>
        </tr>
        <tr>
            <td class="vgtop text_medium"><?php echo mi18n("MSG_IMAGES_BRIGHTNESS") ?></td>
            <td class="text_medium">
                <input type="checkbox" class="text_medium" name="CMS_VAR[33]" id="<?php echo $module->getIdValue('darkImages') ?>" value="1"<?php echo $module->getCheckedAttribute('darkImages') ?> />
                <label for="<?php echo $module->getIdValue('darkImages') ?>"><?php echo mi18n("LBL_IMAGES_BRIGHTNESS") ?></label><br />
                <small><?php echo mi18n("INFO_IMAGES_BRIGHTNESS") ?></small><br />
                <br />
            </td>
        </tr>
        <tr>
            <td class="vgtop text_medium"><?php echo mi18n("MSG_MAX_NUM_IMAGES") ?></td>
            <td class="text_medium">
                <input type="text" class="text_medium" name="CMS_VAR[3]" value="<?php echo $module->maxImages ?>" aria-label="<?php echo mi18n("MSG_MAX_NUM_IMAGES") ?>" /><br />
                <small><?php echo mi18n("INFO_MAX_NUM_IMAGES") ?></small><br />
                <br />
            </td>
        </tr>
        <tr>
            <td class="vgtop text_medium"><?php echo mi18n("MSG_MAX_WIDTH_IMAGES") ?></td>
            <td class="text_medium">
                <input type="text" class="text_medium" name="CMS_VAR[4]" value="<?php echo $module->maxWidth ?>" aria-label="<?php echo mi18n("MSG_MAX_WIDTH_IMAGES") ?>" /> <?php echo mi18n("PIXEL") ?><br />
            </td>
        </tr>
        <tr>
            <td class="vgtop text_medium"><?php echo mi18n("MSG_MAX_HEIGHT_IMAGES") ?></td>
            <td class="text_medium">
                <input type="text" class="text_medium" name="CMS_VAR[5]" value="<?php echo $module->maxHeight ?>" aria-label="<?php echo mi18n("MSG_MAX_HEIGHT_IMAGES") ?>" /> <?php echo mi18n("PIXEL") ?><br />
                <small><?php echo mi18n("INFO_MAX_HEIGHT_IMAGES") ?></small><br />
                <br />
            </td>
        </tr>
        <tr>
            <td class="vgtop text_medium"><?php echo mi18n("MSG_QUALITY_IMAGES") ?></td>
            <td class="text_medium">
                <input type="text" class="text_medium" name="CMS_VAR[34]" value="<?php echo $module->imageQuality ?>" aria-label="<?php echo mi18n("MSG_QUALITY_IMAGES") ?>" /> %<br />
                <small><?php echo mi18n("INFO_QUALITY_IMAGES") ?></small><br />
                <br />
            </td>
        </tr>
        <tr>
            <td class="vgtop text_medium"><?php echo mi18n("MSG_CACHETIME_IMAGES") ?></td>
            <td class="text_medium">
                <input type="text" class="text_medium" name="CMS_VAR[6]" value="<?php echo $module->maxCacheTime ?>" aria-label="<?php echo mi18n("INFO_CACHETIME_IMAGES") ?>"/> <?php echo mi18n("MINUTES") ?><br />
                <small><?php echo mi18n("INFO_CACHETIME_IMAGES") ?></small>
            </td>
        </tr>
        <tr>
            <td class="vgtop text_medium"><?php echo mi18n("MSG_SORT_TYPE") ?></td>
            <td>
                <select name="CMS_VAR[7]" class="text_medium" aria-label="<?php echo mi18n("MSG_SORT_TYPE") ?>">
                    <?php echo $module->generateOrderSelectOptions() ?>
                </select><br />
                <br />
            </td>
        </tr>
        <tr>
            <td class="vgtop text_medium"><?php echo mi18n("MSG_RESPONSIVE_MODE") ?></td>
            <td>
                <input type="checkbox" class="text_medium" name="CMS_VAR[35]" id="<?php echo $module->getIdValue('responsiveMode') ?>" value="1"<?php echo $module->getCheckedAttribute('responsiveMode') ?> />
                <label for="<?php echo $module->getIdValue('responsiveMode') ?>"><?php echo mi18n("LBL_RESPONSIVE_MODE") ?></label><br />
                <small><?php echo mi18n("INFO_RESPONSIVE_MODE") ?></small><br />
                <br />
            </td>
        </tr>
        <!-- Nivo Slider JS settings -->
        <tr>
            <td colspan="2" class="text_medium">
                <hr /><br />
                <b><?php echo mi18n("MSG_NIVO_SLIDER_SETTINGS") ?></b>
            </td>
        </tr>
        <tr>
            <td class="vgtop text_medium"><?php echo mi18n("EFFECT") ?>:</td>
            <td class="text_medium">
                <input type="text" class="text_medium" name="CMS_VAR[8]" value="<?php echo $module->effect ?>" aria-label="<?php echo mi18n("MSG_EFFECT") ?>" /> <small><?php echo mi18n("INFO_EFFECT") ?></small> <br />
                <?php
                $effects = implode(', ', explode(',', Purc\Module\MpNivoSlider\Input::EFFECTS)) . '.';
                ?>
                <span style="text-decoration:underline"><?php echo mi18n("INFO2_EFFECT") ?>:</span><br />
                <?php echo $effects ?>
                <?php
                unset($effects);
                ?>
            </td>
        </tr>
        <tr>
            <td class="vgtop text_medium"><?php echo mi18n("MSG_NUM_SLIDES") ?>:</td>
            <td class="text_medium">
                <input type="text" class="text_medium" name="CMS_VAR[9]" value="<?php echo $module->slices ?>" aria-label="<?php echo mi18n("MSG_NUM_SLIDES") ?>" /> <small><?php echo mi18n("INFO_NUM_SLIDES") ?></small>
            </td>
        </tr>
        <tr>
            <td class="vgtop text_medium"><?php echo mi18n("MSG_NUM_COLS") ?>:</td>
            <td class="text_medium">
                <input type="text" class="text_medium" name="CMS_VAR[10]" value="<?php echo $module->boxCols ?>" aria-label="<?php echo mi18n("MSG_NUM_COLS") ?>" /> <small><?php echo mi18n("INFO_NUM_COLS") ?></small>
            </td>
        </tr>
        <tr>
            <td class="vgtop text_medium"><?php echo mi18n("MSG_NUM_ROWS") ?>:</td>
            <td class="text_medium">
                <input type="text" class="text_medium" name="CMS_VAR[11]" value="<?php echo $module->boxRows ?>" aria-label="<?php echo mi18n("MSG_NUM_ROWS") ?>" /> <small><?php echo mi18n("INFO_NUM_ROWS") ?></small>
            </td>
        </tr>
        <tr>
            <td class="vgtop text_medium"><?php echo mi18n("MSG_ANIM_SPEED") ?>:</td>
            <td class="text_medium">
                <input type="text" class="text_medium" name="CMS_VAR[12]" value="<?php echo $module->animSpeed ?>" aria-label="<?php echo mi18n("MSG_ANIM_SPEED") ?>"/> <?php echo mi18n("MILLISECONDS") ?> <br />
                <small><?php echo mi18n("INFO_ANIM_SPEED") ?></small>
            </td>
        </tr>
        <tr>
            <td class="vgtop text_medium"><?php echo mi18n("MSG_TIME_BETWEEN_SLIDES") ?>:</td>
            <td class="text_medium">
                <input type="text" class="text_medium" name="CMS_VAR[13]" value="<?php echo $module->pauseTime ?>" aria-label="<?php echo mi18n("MSG_TIME_BETWEEN_SLIDES") ?>"/> <?php echo mi18n("MILLISECONDS") ?> <br />
            </td>
        </tr>
        <tr>
            <td class="vgtop text_medium"><?php echo mi18n("MSG_STARTPOS") ?>:</td>
            <td class="text_medium">
                <input type="text" class="text_medium" name="CMS_VAR[14]" value="<?php echo $module->startSlide ?>" aria-label="<?php echo mi18n("MSG2_STARTPOS") ?>"/> <?php echo mi18n("MSG2_STARTPOS") ?> <br />
                <small><?php echo mi18n("INFO_STARTPOS") ?></small>
            </td>
        </tr>
        <!-- navigation -->
        <tr>
            <td class="vgtop text_medium"><?php echo mi18n("MSG_NAVIGATION") ?>:</td>
            <td class="text_medium">
                <input type="checkbox" class="text_medium" name="CMS_VAR[15]" id="<?php echo $module->getIdValue('directionNav') ?>" value="1"<?php echo $module->getCheckedAttribute('directionNav') ?> aria-label="<?php echo mi18n("LBL_ENABLE_NAVIGATION") ?>"/>
                <label for="<?php echo $module->getIdValue('directionNav') ?>"><?php echo mi18n("LBL_ENABLE_NAVIGATION") ?></label><br />
                <br />
                <input type="text" class="text_medium" name="CMS_VAR[26]" value="<?php echo $module->prevText ?>" aria-label="<?php echo mi18n("LBL_TEXT_PREVIOUS") ?>"/> <?php echo mi18n("LBL_TEXT_PREVIOUS") ?><br />
                <br />
                <input type="text" class="text_medium" name="CMS_VAR[27]" value="<?php echo $module->nextText ?>" aria-label="<?php echo mi18n("LBL_TEXT_NEXT") ?>"/> <?php echo mi18n("LBL_TEXT_NEXT") ?><br />
                <br />
            </td>
        </tr>
        <tr>
            <td class="vgtop text_medium"><?php echo mi18n("MSG_EXTENDED_NAVIGATION") ?>:</td>
            <td class="text_medium">
                <input type="checkbox" class="text_medium" name="CMS_VAR[17]" id="<?php echo $module->getIdValue('controlNav') ?>" value="1"<?php echo $module->getCheckedAttribute('controlNav') ?> />
                <label for="<?php echo $module->getIdValue('controlNav') ?>"><?php echo mi18n("LBL_ENABLE_EXTENDED_NAVIGATION") ?></label><br />
                <br />
                <div style="padding-left:20px;">
                    <input type="checkbox" class="text_medium" name="CMS_VAR[18]" id="<?php echo $module->getIdValue('controlNavThumbs') ?>" value="1"<?php echo $module->getCheckedAttribute('controlNavThumbs') ?> />
                    <label for="<?php echo $module->getIdValue('controlNavThumbs') ?>"><?php echo mi18n("LBL_USE_THUMBNAILS") ?></label><br />
                </div>
                <br />
                <input type="text" class="text_medium" name="CMS_VAR[20]" value="<?php echo $module->controlNavThumbsWidthX ?>" aria-label="<?php echo mi18n("LBL_THUMBNAIL_WIDTH") ?>"/> <?php echo mi18n("LBL_THUMBNAIL_WIDTH") ?><br />
                <br />
                <input type="text" class="text_medium" name="CMS_VAR[21]" value="<?php echo $module->controlNavThumbsHeightX ?>" aria-label="<?php echo mi18n("LBL_THUMBNAIL_HEIGHT") ?>"/> <?php echo mi18n("LBL_THUMBNAIL_HEIGHT") ?><br />
            </td>
        </tr>
        <tr>
            <td class="vgtop text_medium"><?php echo mi18n("MSG_STOP_ON_MOUSEOVER") ?>:</td>
            <td class="text_medium">
                <input type="checkbox" class="text_medium" name="CMS_VAR[23]" id="<?php echo $module->getIdValue('pauseOnHover') ?>" value="1"<?php echo $module->getCheckedAttribute('pauseOnHover') ?> />
                <label for="<?php echo $module->getIdValue('pauseOnHover') ?>"><?php echo mi18n("LBL_STOP_ON_MOUSEOVER") ?></label><br />
                <br />
            </td>
        </tr>
        <tr>
            <td class="vgtop text_medium"><?php echo mi18n("MSG_MANUAL_SLIDES") ?>:</td>
            <td class="text_medium">
                <input type="checkbox" class="text_medium" name="CMS_VAR[24]" id="<?php echo $module->getIdValue('manualAdvance') ?>" value="1"<?php echo $module->getCheckedAttribute('manualAdvance') ?> />
                <label for="<?php echo $module->getIdValue('manualAdvance') ?>"><?php echo mi18n("LBL_MANUAL_SLIDES") ?></label><br />
                <br />
            </td>
        </tr>
        <!-- javascript event handler -->
        <tr>
            <td colspan="2" class="text_medium"><b><?php echo mi18n("MSG_NIVO_SLIDER_JS_EVENTS") ?></b></td>
        </tr>
        <tr>
            <td class="vgtop text_medium"><?php echo mi18n("MSG_ON_BEFORECHANGE") ?>:</td>
            <td class="text_medium">
                <?php echo '<textarea name="CMS_VAR[28]" cols="80" rows="2" style="width:350px;font-family:monospace;">' . $module->beforeChange . '</textarea>'; ?>
                <?php echo mi18n("INFO_ON_BEFORECHANGE") ?>
                <br />
            </td>
        </tr>
        <tr>
            <td class="vgtop text_medium"><?php echo mi18n("MSG_ON_AFTERCHANGE") ?>:</td>
            <td class="text_medium">
                <?php echo '<textarea name="CMS_VAR[29]" cols="80" rows="2" style="width:350px;font-family:monospace;">' . $module->afterChange . '</textarea>'; ?>
                <?php echo mi18n("INFO_ON_AFTERCHANGE") ?>
                <br />
            </td>
        </tr>
        <tr>
            <td class="vgtop text_medium"><?php echo mi18n("MSG_ON_SLIDESHOWEND") ?>:</td>
            <td class="text_medium">
                <?php echo '<textarea name="CMS_VAR[30]" cols="80" rows="2" style="width:350px;font-family:monospace;">' . $module->slideshowEnd . '</textarea>'; ?>
                <?php echo mi18n("INFO_ON_SLIDESHOWEND") ?>
                <br />
            </td>
        </tr>
        <tr>
            <td class="vgtop text_medium"><?php echo mi18n("MSG_ON_LASTSLIDE") ?>:</td>
            <td class="text_medium">
                <?php echo '<textarea name="CMS_VAR[31]" cols="80" rows="2" style="width:350px;font-family:monospace;">' . $module->lastSlide . '</textarea>'; ?>
                <?php echo mi18n("INFO_ON_LASTSLIDE") ?>
                <br />
            </td>
        </tr>
        <tr>
            <td class="vgtop text_medium"><?php echo mi18n("MSG_ON_AFTERLOAD") ?>:</td>
            <td class="text_medium">
                <?php echo '<textarea name="CMS_VAR[32]" cols="80" rows="2" style="width:350px;font-family:monospace;">' . $module->afterLoad . '</textarea>'; ?>
                <?php echo mi18n("INFO_ON_AFTERLOAD") ?>
                <br />
            </td>
        </tr>
    </table>
    <!-- /module mpNivoSlider -->

    <?php

})();
