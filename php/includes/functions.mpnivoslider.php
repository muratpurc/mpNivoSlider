<?php
/**
 * Project:
 * CONTENIDO Content Management System
 *
 * Description:
 * Helper functions for mpNivoSlider module
 *
 * @package     CONTENIDO_Modules
 * @subpackage  mpNivoSlider
 * @author      Murat Purç <murat@purc.de>
 * @copyright   Murat Purç (https://www.purc.de)
 * @license     http://www.gnu.org/licenses/gpl-2.0.html - GNU General Public License, version 2
 */


if (!defined('CON_FRAMEWORK')) {
    die('Illegal call');
}


/**
 * Returns modules translations
 * NOTE: Has to run in modules context, because mi18n() works with current modules id!
 * @return array
 */
function module_mpNivoSlider_getModuleTranslations() {
    // Return module translation
    return array(
        'random' => mi18n("RANDOM"),
        'filename_asc' => mi18n("FILENAME_ASC"),
        'filename_desc' => mi18n("FILENAME_DESC"),
        'size_asc' => mi18n("SIZE_ASC"),
        'size_desc' => mi18n("SIZE_DESC"),
        'filetype_asc' => mi18n("FILETYPE_ASC"),
        'filetype_desc' => mi18n("FILETYPE_DESC"),
        'created_asc' => mi18n("CREATED_ASC"),
        'created_esc' => mi18n("CREATED_ESC"),
        'id_asc' => mi18n("ID_ASC"),
        'id_desc' => mi18n("ID_DESC"),
        '__select_folder__' => mi18n("__SELECT_FOLDER__"),
        '__select_order__' => mi18n("__SELECT_ORDER__"),
        'previous' => mi18n("PREVIOUS"),
        'next' => mi18n("NEXT"),
    );
}
