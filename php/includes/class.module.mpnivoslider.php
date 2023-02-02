<?php
/**
 * Project:
 * CONTENIDO Content Management System
 *
 * Description:
 * CONTENIDO abstract module class for mpNivoSlider
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
 * CONTENIDO abstract module class for mpNivoSlider.
 *
 * @property mixed|null afterChange
 * @property mixed|null afterLoad
 * @property mixed|null animSpeed
 * @property mixed|null beforeChange
 * @property mixed|null boxCols
 * @property mixed|null boxRows
 * @property mixed|null container
 * @property mixed|null controlNav
 * @property mixed|null controlNavThumbs
 * @property mixed|null controlNavThumbsHeightX
 * @property mixed|null controlNavThumbsWidthX
 * @property mixed|null darkImages
 * @property mixed|null directionNav
 * @property mixed|null effect
 * @property int idmod
 * @property int imageQuality
 * @property mixed|null lastSlide
 * @property mixed|null manualAdvance
 * @property mixed|null maxCacheTime
 * @property mixed|null maxHeight
 * @property mixed|null maxImages
 * @property mixed|null maxWidth
 * @property string name
 * @property mixed|null nextText
 * @property mixed|null pauseOnHover
 * @property mixed|null pauseTime
 * @property mixed|null prevText
 * @property mixed|null responsiveMode
 * @property mixed|string|null selectedDirname
 * @property mixed|null selectedOrder
 * @property mixed|null slices
 * @property mixed|null slideshowEnd
 * @property mixed|null startSlide
 * @property mixed|null useSubdirectories
 */
abstract class ModuleMpNivoSliderAbstract
{
    /**
     * Default cache time of resized images in minutes (0 = no limit)
     * @var  int
     */
    const DEFAULT_CACHE_TIME = 0;

    /**
     * Default quality for downsized jpeg images
     * @var  int
     */
    const DEFAULT_QUALITY = 90;

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
     * Associative order array
     * @var  array
     */
    protected $_aOrder;

    /**
     * Client id
     * @var  int
     */
    protected $_client;

    /**
     * Language id
     * @var  int
     */
    protected $_lang;

    /**
     * Client HTML path
     * @var  string
     */
    protected $_sHtmlPath;

    /**
     * Client upload directory
     * @var  string
     */
    protected $_sUploadDir;

    /**
     * Absolute path to client upload directory
     * @var  string
     */
    protected $_sAbsUploadPath;

    /**
     * Html path of current module
     * @var  string
     */
    protected $_sModulePath;

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
        'name' => '',
        'idmod' => 0,
        'container' => 0,

        'selectedDirname' => '',
        'useSubdirectories' => '',
        'maxImages' => '',
        'maxWidth' => '',
        'maxHeight' => '',
        'maxCacheTime' => '',
        'selectedOrder' => '',
		'darkImages' => '',
		'imageQuality' => '',
		'responsiveMode' => '',

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
     * @param  array  $aTranslations  Associative translations list
     * @param  int    $clientId   Client id
     * @param  array  $aClientCfg  Client configuration
     * @param  int    $iLangId  Language id
     */
    public function __construct(array $aConfig, array $aTranslations, $clientId = null, array $aClientCfg = array(), $iLangId = null)
    {
        if ((int) $clientId <= 0) {
            $clientId = (int) cRegistry::getClientId();
        }
        if (empty($aClientCfg)) {
            $aClientCfg = cRegistry::getClientConfig(cRegistry::getClientId());
        }
        if ((int) $iLangId <= 0) {
            $iLangId = (int) cRegistry::getLanguageId();
        }

        $this->_client         = $clientId;
        $this->_lang           = $iLangId;
        $this->_i18n           = $aTranslations;
		$this->_uid            = uniqid();
        $this->_sHtmlPath      = $aClientCfg['path']['htmlpath'];
        $this->_sUploadDir     = $aClientCfg['upl']['frontendpath'];
        $this->_sAbsUploadPath = $aClientCfg['upl']['path'];
        $this->_sModulePath    = $aClientCfg['module']['frontendpath'];

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
     * @param  array  $translations  Associative translations list
     */
    public function setMi18n(array $translations)
    {
        $this->_i18n = array_merge($this->_i18n, $translations);
    }

    /**
     * Validates module configuration
     */
    protected function _validate() {
        $this->useSubdirectories = trim($this->useSubdirectories);

        // number of max images to display
        $this->maxImages = (int) $this->maxImages;
        if ($this->maxImages <= 1) {
            $this->maxImages = '';
        }

        // max allowed width of images. bigger ones will be resized
        $this->maxWidth = (int) $this->maxWidth;
        if ($this->maxWidth <= 0) {
            $this->maxWidth = '';
        }

        // max allowed height of images. bigger ones will also be resized
        $this->maxHeight = (int) $this->maxHeight;
        if ($this->maxHeight <= 0) {
            $this->maxHeight = '';
        }

        // quality of resized jpeg images
        if ($this->imageQuality < 0 || $this->imageQuality > 100) {
            $this->imageQuality = self::DEFAULT_QUALITY;
        }

        // responsive mode flag
        $this->responsiveMode = (int) $this->responsiveMode;
        if ($this->responsiveMode < 0) {
            $this->responsiveMode = '';
        }

        // max cachetime in minutes 4 resized images
        $this->maxCacheTime = (int) $this->maxCacheTime;
        if ($this->maxCacheTime < 0) {
            $this->maxCacheTime = self::DEFAULT_CACHE_TIME;
        }

        $this->effect = trim($this->effect);
        if ($this->effect == '') {
            $this->effect = 'random';
        }

        $this->slices = (int) $this->slices;
        if ($this->slices <= 0) {
            $this->slices = 15;
        }

        $this->boxCols = (int) $this->boxCols;
        if ($this->boxCols <= 0) {
            $this->boxCols = 8;
        }

        $this->boxRows = (int) $this->boxRows;
        if ($this->boxRows <= 0) {
            $this->boxRows = 4;
        }

        $this->animSpeed = (int) $this->animSpeed;
        if ($this->animSpeed <= 0) {
            $this->animSpeed = 500;
        }

        $this->pauseTime = (int) $this->pauseTime;
        if ($this->pauseTime <= 0) {
            $this->pauseTime = 5000;
        }

        $this->startSlide = (int) $this->startSlide;
        if ($this->startSlide <= 0) {
            $this->startSlide = '';
        }

        $this->directionNav = trim($this->directionNav);
        $this->controlNav = trim($this->controlNav);
        $this->controlNavThumbs = trim($this->controlNavThumbs);
        $this->controlNavThumbsWidthX = (int) $this->controlNavThumbsWidthX;
        $this->controlNavThumbsHeightX = (int) $this->controlNavThumbsHeightX;
        $this->pauseOnHover = trim($this->pauseOnHover);
        $this->manualAdvance = trim($this->manualAdvance);
        $this->prevText = trim($this->prevText);
        $this->nextText = trim($this->nextText);
        $this->beforeChange = trim($this->beforeChange);
        $this->afterChange = trim($this->afterChange);
        $this->slideshowEnd = trim($this->slideshowEnd);
        $this->lastSlide = trim($this->lastSlide);
        $this->afterLoad = trim($this->afterLoad);
    }

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
