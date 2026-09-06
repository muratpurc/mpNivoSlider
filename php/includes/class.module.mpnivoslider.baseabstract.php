<?php

namespace Purc\Module\MpNivoSlider;

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

defined('CON_FRAMEWORK') || die('Illegal call!');

/**
 * CONTENIDO abstract module class for mpNivoSlider.
 *
 * @property string $name
 * @property int $idmod
 * @property mixed|null $container
 * @property bool $isBackend
 * @property array $clientCfg
 *
 * @property mixed|null $afterChange
 * @property mixed|null $afterLoad
 * @property mixed|null $animSpeed
 * @property mixed|null $beforeChange
 * @property mixed|null $boxCols
 * @property mixed|null $boxRows
 * @property mixed|null $controlNav
 * @property mixed|null $controlNavThumbs
 * @property mixed|null $controlNavThumbsHeightX
 * @property mixed|null $controlNavThumbsWidthX
 * @property mixed|null $darkImages
 * @property mixed|null $directionNav
 * @property mixed|null $effect
 * @property int $imageQuality
 * @property mixed|null $lastSlide
 * @property mixed|null $manualAdvance
 * @property mixed|null $maxCacheTime
 * @property mixed|null $maxHeight
 * @property mixed|null $maxImages
 * @property mixed|null $maxWidth
 * @property mixed|null $nextText
 * @property mixed|null $pauseOnHover
 * @property mixed|null $pauseTime
 * @property mixed|null $prevText
 * @property mixed|null $responsiveMode
 * @property mixed|string|null $selectedDirname
 * @property mixed|null $selectedOrder
 * @property mixed|null $slices
 * @property mixed|null $slideshowEnd
 * @property mixed|null $startSlide
 * @property mixed|null $useSubdirectories
 */
abstract class BaseAbstract
{

    /**
     * Default cache time of resized images in minutes (0 = no limit)
     * @var int
     */
    public const DEFAULT_CACHE_TIME = 0;

    /**
     * Default quality for downsized jpeg images
     * @var int
     */
    public const DEFAULT_QUALITY = 90;

    /**
     * Default image width
     * @var string
     */
    public const DEFAULT_WIDTH = '100%';

    /**
     * Default image height
     * @var string
     */
    public const DEFAULT_HEIGHT = '100%';

    /**
     * Supported filetypes for the slideshow
     * @var string
     */
    public const FILE_TYPES = "'jpg','jpeg','png','gif'";

    /**
     * Comma separated list of allowed effects
     * @var string
     */
    public const EFFECTS = 'sliceDown,sliceDownLeft,sliceUp,sliceUpLeft,sliceUpDown,sliceUpDownLeft,fold,fade,random,slideInRight,slideInLeft,boxRandom,boxRain,boxRainReverse,boxRainGrow,boxRainGrowReverse';

    /**
     * Associative order array
     */
    protected array $order;

    /**
     * Client id
     */
    protected int $client;

    /**
     * Language id
     */
    protected int $lang;

    /**
     * Client HTML path
     */
    protected string $htmlPath;

    /**
     * Client upload directory
     */
    protected string $uploadDir;

    /**
     * Absolute path to the client upload directory
     */
    protected string $absUploadPath;

    /**
     * HTML path of the current module
     */
    protected string $modulePath;

    /**
     * Module translations
     * @var string[]
     */
    protected array $i18n = [];

    /**
     * Unique module id
     */
    protected string $uid;

    /**
     * Module configuration structure
     */
    protected array $cmsData = [
        'name' => '',
        'idmod' => 0,
        'container' => 0,
        'isBackend' => false,
        'clientCfg' => [],

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
    ];

    /**
     * Constructor sets some properties
     *
     * @param array $properties Module properties
     */
    public function __construct(array $properties)
    {
        foreach ($properties as $k => $v) {
            $this->$k = $v;
        }

        $this->uid = uniqid();
        $this->htmlPath = $this->clientCfg['path']['htmlpath'];
        $this->uploadDir = $this->clientCfg['upl']['frontendpath'];
        $this->absUploadPath = $this->clientCfg['upl']['path'];
        $this->modulePath = $this->clientCfg['module']['frontendpath'];

        $this->order = [
            'RAND()' => $this->i18n['random'],
            'filename:ASC' => $this->i18n['filename_asc'],
            'filename:DESC' => $this->i18n['filename_desc'],
            'size:ASC' => $this->i18n['size_asc'],
            'size:DESC' => $this->i18n['filename_desc'],
            'filetype:ASC' => $this->i18n['filetype_asc'],
            'filetype:DESC' => $this->i18n['filetype_desc'],
            'created:ASC' => $this->i18n['created_asc'],
            'created:esc' => $this->i18n['created_esc'],
            'idupl:ASC' => $this->i18n['id_asc'],
            'idupl:DESC' => $this->i18n['id_desc']
        ];

        $this->validate();
    }

    public function __get($name)
    {
        return (isset($this->cmsData[$name])) ? $this->cmsData[$name] : null;
    }

    public function __set($name, $value)
    {
        if (isset($this->cmsData[$name])) {
            $this->cmsData[$name] = $value;
        }
    }

    public function __isset($name)
    {
        return (isset($this->cmsData[$name]));
    }

    public function __unset($name)
    {
        if (isset($this->cmsData[$name])) {
            unset($this->cmsData[$name]);
        }
    }

    /**
     * Sets module translations
     *
     * @param array $translations Associative translations list
     */
    public function setMi18n(array $translations): void
    {
        $this->i18n = array_merge($this->i18n, $translations);
    }

    /**
     * Validates module configuration
     */
    protected function validate(): void
    {
        $this->useSubdirectories = trim($this->useSubdirectories);

        // Number of max images to display
        $this->maxImages = (int)$this->maxImages;
        if ($this->maxImages <= 1) {
            $this->maxImages = '';
        }

        // Max allowed width of images. bigger ones will be resized
        $this->maxWidth = (int)$this->maxWidth;
        if ($this->maxWidth <= 0) {
            $this->maxWidth = '';
        }

        // Max allowed height of images. bigger ones will also be resized
        $this->maxHeight = (int)$this->maxHeight;
        if ($this->maxHeight <= 0) {
            $this->maxHeight = '';
        }

        // Quality of resized jpeg images
        if ($this->imageQuality < 0 || $this->imageQuality > 100) {
            $this->imageQuality = BaseAbstract::DEFAULT_QUALITY;
        }

        // Responsive mode flag
        $this->responsiveMode = (int)$this->responsiveMode;
        if ($this->responsiveMode < 0) {
            $this->responsiveMode = '';
        }

        // Max cache time in minutes 4 resized images
        $this->maxCacheTime = (int)$this->maxCacheTime;
        if ($this->maxCacheTime < 0) {
            $this->maxCacheTime = BaseAbstract::DEFAULT_CACHE_TIME;
        }

        $this->effect = trim($this->effect);
        if ($this->effect == '') {
            $this->effect = 'random';
        }

        $this->slices = (int)$this->slices;
        if ($this->slices <= 0) {
            $this->slices = 15;
        }

        $this->boxCols = (int)$this->boxCols;
        if ($this->boxCols <= 0) {
            $this->boxCols = 8;
        }

        $this->boxRows = (int)$this->boxRows;
        if ($this->boxRows <= 0) {
            $this->boxRows = 4;
        }

        $this->animSpeed = (int)$this->animSpeed;
        if ($this->animSpeed <= 0) {
            $this->animSpeed = 500;
        }

        $this->pauseTime = (int)$this->pauseTime;
        if ($this->pauseTime <= 0) {
            $this->pauseTime = 5000;
        }

        $this->startSlide = (int)$this->startSlide;
        if ($this->startSlide <= 0) {
            $this->startSlide = '';
        }

        $this->directionNav = trim($this->directionNav);
        $this->controlNav = trim($this->controlNav);
        $this->controlNavThumbs = trim($this->controlNavThumbs);
        $this->controlNavThumbsWidthX = (int)$this->controlNavThumbsWidthX;
        $this->controlNavThumbsHeightX = (int)$this->controlNavThumbsHeightX;
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
     * Returns the checked attribute substring usable for checkboxes.
     *
     * @param string $name Configuration item name
     */
    public function getCheckedAttribute(string $name): string
    {
        if (isset($this->$name) && '' !== $this->$name) {
            return ' checked="checked"';
        } else {
            return '';
        }
    }

    /**
     * Returns the id attribute value by concatenating the passed name with the module uid.
     */
    public function getIdValue(string $name): string
    {
        return $name . '_' . $this->getUid();
    }

    /**
     * Returns the module uid.
     */
    public function getUid(): string
    {
        return $this->uid;
    }

}
