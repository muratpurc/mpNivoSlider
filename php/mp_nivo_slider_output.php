<?php
/**
 * Module-Output: mpNivoSlider
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


(function() {

    global $cCurrentModule, $cCurrentContainer;

    // Includes
    if (!class_exists(\Purc\Module\MpNivoSlider\Output::class)) {
        cInclude('module', 'includes/functions.mpnivoslider.php');
        cInclude('module', 'includes/class.module.mpnivoslider.output.php');
    }
    cInclude('includes', 'functions.api.images.php');

    // Create mpNivoSlider module instance
    $module = new \Purc\Module\MpNivoSlider\Output([
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

    // Generate the slider
    $viewData = $module->getViewData();
    $tpl = cSmartyFrontend::getInstance();
    $tpl->assign('viewData', $viewData);
    $tpl->display('get.tpl');

})();

?>