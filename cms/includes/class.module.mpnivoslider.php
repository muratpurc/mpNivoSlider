<?php
/**
 * Project:
 * CONTENIDO Content Management System
 *
 * Description:
 * CONTENIDO abstract module class for mpNivoSlider
 *
 * Requirements:
 * @con_php_req 5.0
 *
 * @package     CONTENIDO_Modules
 * @subpackage  mpNivoSlider
 * @author      Murat Purc <murat@purc.de>
 * @copyright   Copyright (c) 2011-2012 Murat Purc (http://www.purc.de)
 * @license     http://www.gnu.org/licenses/gpl-2.0.html - GNU General Public License, version 2
 * @version     $Id: class.module.mpnivoslider.php 5 2012-09-07 19:22:49Z murat $
 */


if (!defined('CON_FRAMEWORK')) {
    die('Illegal call');
}

/**
 * CONTENIDO abstract module class for mpNivoSlider
 */
abstract class ModuleMpNivoSliderAbstract
{
    /**
     * Default cache time of resized images in minutes (0 = no limit)
     * @var  int
     */
    const DEFAULT_CACHETIME = 0;

    /**
     * Default quality for downsized jpeg images
     * @var  int
     */
    const DEFAULT_QUALITY = 85;

    /**
     * Default image width
     * @var  string
     */
    const DEFAULT_WIDTH = '100%';

    /**
     * Default image height
     * @var  string
     */
    const DEFAULT_HEIGHT = '100%';

    /**
     * Supported filetypes for the slideshow
     * @var  string
     */
    const FILE_TYPES = "'jpg','jpeg','png','gif'";

    /**
     * Comma separated list of allowed effects
     * @var  string
     */
    const EFFECTS = 'sliceDown,sliceDownLeft,sliceUp,sliceUpLeft,sliceUpDown,sliceUpDownLeft,fold,fade,random,slideInRight,slideInLeft,boxRandom,boxRain,boxRainReverse,boxRainGrow,boxRainGrowReverse';

    /**
     * Template for image captions
     * @var  string
     */
    const CAPTIONS_TPL = '
<!-- BEGIN:BLOCK -->
<div id="{ID}" class="nivo-html-caption">
    {TEXT}
</div><!-- END:BLOCK -->';

    /**
     * Assoziative order array
     * @var  array
     */
    protected $_aOrder;

    /**
     * Client id
     * @var  int
     */
    protected $_client;

    /**
     * Module translations
     * @var  array
     */
    protected $_i18n = array();

	/**
	 * Unique module id
	 * @var  string
	 */
	 protected $_uid;

    /**
     * Module configuration structure
     * @var  array
     */
    protected $_cmsData = array(
        'selectedDirname' => '',
        'useSubdirectories' => '',
        'maxImages' => '',
        'maxWidth' => '',
        'maxHeight' => '',
        'maxCachetime' => '',
        'selectedOrder' => '',
		'darkImages' => '',
		'imageQuality' => '',

        'effect' => '',
        'slices' => '',
        'boxCols' => '',
        'boxRows' => '',
        'animSpeed' => '',
        'pauseTime' => '',
        'startSlide' => '',
        'directionNav' => '',
        'controlNav' => '',
        'controlNavThumbs' => '',
        'controlNavThumbsWidthX' => '',
        'controlNavThumbsHeightX' => '',
        'pauseOnHover' => '',
        'manualAdvance' => '',
        'prevText' => '',
        'nextText' => '',
        'beforeChange' => '',
        'afterChange' => '',
        'slideshowEnd' => '',
        'lastSlide' => '',
        'afterLoad' => '',
    );


    /**
     * Constructor sets some properties
     *
     * @param  array  $aConfig  Module configuration
     * @param  array  $aTranslations  Assoziative translations list
     * @param  int    $clientId   Client id
     * @param  array  $aClientCfg  Client configuration
     * @param  int    $iLangId  Language id
     */
    public function __construct(array $aConfig, array $aTranslations, $clientId = null, array $aClientCfg = array(), $iLangId = null)
    {
        global $cfgClient, $client, $lang;

        if ((int) $clientId <= 0) {
            $clientId = (int) $client;
        }
        if (empty($aClientCfg)) {
            $aClientCfg = $cfgClient[$client];
        }
        if ((int) $iLangId <= 0) {
            $iLangId = (int) $lang;
        }

        $this->_client         = $clientId;
        $this->_lang           = $iLangId;
        $this->_i18n           = $aTranslations;
		$this->_uid            = uniqid();
        $this->_sHtmlPath      = $aClientCfg['path']['htmlpath'];
        $this->_sUploadDir     = $aClientCfg['upl']['frontendpath'];
        $this->_sAbsUploadPath = $aClientCfg['upl']['path'];

        foreach ($aConfig as $k => $v) {
            $this->$k = $v;
        }

        $this->_aOrder = array(
            'RAND()'         => $this->_i18n['random'],
            'filename:ASC'   => $this->_i18n['filename_asc'],
            'filename:DESC'  => $this->_i18n['filename_desc'],
            'size:ASC'       => $this->_i18n['size_asc'],
            'size:DESC'      => $this->_i18n['filename_desc'],
            'filetype:ASC'   => $this->_i18n['filetype_asc'],
            'filetype:DESC'  => $this->_i18n['filetype_desc'],
            'created:ASC'    => $this->_i18n['created_asc'],
            'created:esc'    => $this->_i18n['created_esc'],
            'idupl:ASC'      => $this->_i18n['id_asc'],
            'idupl:DESC'     => $this->_i18n['id_desc']
        );

        $this->_validate();
    }

    public function __get($name)
    {
        return (isset($this->_cmsData[$name])) ? $this->_cmsData[$name] : null;
    }

    public function __set($name, $value)
    {
        if (isset($this->_cmsData[$name])) {
            $this->_cmsData[$name] = $value;
        }
    }

    public function __isset($name)
    {
        return (isset($this->_cmsData[$name]));
    }

    public function __unset($name)
    {
        if (isset($this->_cmsData[$name])) {
            unset($this->_cmsData[$name]);
        }
    }

    /**
     * Sets module translations
	 *
     * @param  array  $translations  Assoziative translations list
     */
    public function setMi18n(array $aTranslations)
    {
        $this->_i18n = array_merge($this->_i18n, $translations);
    }

    /**
     * Validates module configuration
     */
    abstract protected function _validate();

    /**
     * Returns the checked attribute sub string usable for checkboxes.
     *
     * @param string $name Configuration item name
     * @return string
     */
    public function getCheckedAttribute($name)
    {
        if (isset($this->$name) && '' !== $this->$name) {
            return ' checked="checked"';
        } else {
            return '';
        }
    }

    /**
     * Returns the id attribute value by concatenating passed name with the module uid.
     *
     * @param string $name
     * @return string
     */
    public function getIdValue($name)
    {
		return $name . '_' . $this->getUid();
    }

    /**
     * Returns the module uid.
     *
     * @return string
     */
	public function getUid()
	{
		return $this->_uid;
	}

}
