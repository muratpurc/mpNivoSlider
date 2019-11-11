<?php
/**
 * Project:
 * CONTENIDO Content Management System
 *
 * Description:
 * Helper functions for mpNivoSlider module
 *
 * Requirements:
 * @con_php_req 5.0
 *
 * @package     CONTENIDO_Modules
 * @subpackage  mpNivoSlider
 * @author      Murat Purc <murat@purc.de>
 * @copyright   Copyright (c) 2012 Murat Purc (http://www.purc.de)
 * @license     http://www.gnu.org/licenses/gpl-2.0.html - GNU General Public License, version 2
 * @version     $Id: functions.mpnivoslider.php 281 2012-09-07 14:40:40Z murat $
 */


if (!defined('CON_FRAMEWORK')) {
    die('Illegal call');
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
