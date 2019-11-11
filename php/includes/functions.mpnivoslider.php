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
 * @author      Murat Purc <murat@purc.de>
 * @copyright   Copyright (c) 2011-2013 Murat Purc (http://www.purc.de)
 * @license     http://www.gnu.org/licenses/gpl-2.0.html - GNU General Public License, version 2
 * @version     $Id: functions.mpnivoslider.php 5 2012-09-07 19:22:49Z murat $
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


// Implementing the json_encode() function for PHP versions earlier than PHP 5.2
// Thanks to 123koenig.de for contributing this solution
if (!function_exists('json_encode')) {
	function json_encode($data) {
		switch ($type = gettype($data)) {
			case 'NULL':
				return 'null';
			case 'boolean':
				return ($data ? 'true' : 'false');
			case 'integer':
			case 'double':
			case 'float':
				return $data;
			case 'string':
				return '"' . addslashes($data) . '"';
			case 'object':
				$data = get_object_vars($data);
			case 'array':
				$output_index_count = 0;
				$output_indexed = array();
				$output_associative = array();
				foreach ($data as $key => $value) {
					$output_indexed[] = json_encode($value);
					$output_associative[] = json_encode($key) . ':' . json_encode($value);
					if ($output_index_count !== NULL && $output_index_count++ !== $key) {
						$output_index_count = NULL;
					}
				}
				if ($output_index_count !== NULL) {
					return '[' . implode(',', $output_indexed) . ']';
				} else {
					return '{' . implode(',', $output_associative) . '}';
				}
			default:
				return ''; // Not supported
		}
	}
}
