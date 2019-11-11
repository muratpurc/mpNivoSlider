<?php
/**
 * Project:
 * CONTENIDO Content Management System
 *
 * Description:
 * CONTENIDO module output class for mpNivoSlider
 *
 * Requirements:
 * @con_php_req 5.0
 *
 * @package     CONTENIDO_Modules
 * @subpackage  mpNivoSlider
 * @author      Murat Purc <murat@purc.de>
 * @copyright   Copyright (c) 2011-2012 Murat Purc (http://www.purc.de)
 * @license     http://www.gnu.org/licenses/gpl-2.0.html - GNU General Public License, version 2
 * @version     $Id: class.module.mpnivoslider.output.php 279 2012-09-07 13:53:45Z murat $
 */


if (!defined('CON_FRAMEWORK')) {
    die('Illegal call');
}

cInclude('frontend', 'includes/class.module.mpnivoslider.php');


/**
 * CONTENIDO module output class for mpNivoSlider
 */
class ModuleMpNivoSliderOutput extends ModuleMpNivoSliderAbstract
{
    /**
     * To store occured errors
     * @var  string
     */
    protected $_sError = '';

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
     * {@inheritdoc}
     */
    protected function _validate()
    {
        // directory including images 4 the slider
        $this->selectedDirname = trim($this->selectedDirname);
        if ($this->selectedDirname == '') {
            $this->_sError = "mpNivoSlider: No image folder selected!";
            return;
        } elseif (!is_dir($this->_sUploadDir . $this->selectedDirname)) {
            $this->_sError = "mpNivoSlider: Selected image folder doesn't exists anymore!";
            return;
        }

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

		// max cachetime in minutes 4 resized images
        $this->maxCachetime = (int) $this->maxCachetime;
        if ($this->maxCachetime < 0) {
            $this->maxCachetime = self::DEFAULT_CACHETIME;
        }

        // selected order type
        $this->selectedOrder = $this->selectedOrder;
        if (!isset($this->selectedOrder[$this->_aOrder])) {
            $this->selectedOrder = 'filename:ASC';
        }

        $allowedEffects = ',' . self::EFFECTS . ',';
        $configuredEffects = explode(',', trim($this->effect));
        $cleanedEffects = array();
        foreach ($configuredEffects as $effect) {
            if (strpos($allowedEffects, ',' . $effect . ',') !== false) {
                $cleanedEffects[] = $effect;
            }
        }
        $this->effect = implode(',', $cleanedEffects);
        if (empty($this->effect)) {
            $this->effect = 'random';
        }

        $this->slices = (int) $this->slices;
        if ($this->slices <= 0) {
            $this->slices = 15;
        }

        $this->boxCols = (int) $this->boxCols;
        if ($this->boxCols <= 0) {
            $this->boxCols = 4;
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
        if ($this->startSlide < 0) {
            $this->startSlide = 0;
        }

        $this->directionNav = trim($this->directionNav);

        $this->controlNav = trim($this->controlNav);
        $this->controlNavThumbs = trim($this->controlNavThumbs);
        $this->controlNavThumbsHeightX = (int) $this->controlNavThumbsHeightX;
        $this->controlNavThumbsWidthX = (int) $this->controlNavThumbsWidthX;
        if ($this->controlNavThumbs) {
            if ($this->controlNavThumbsHeightX <= 0) {
                $this->controlNavThumbsHeightX = 50;
            }
            if ($this->controlNavThumbsWidthX <= 0) {
                $this->controlNavThumbsWidthX = 70;
            }
        }

        $this->pauseOnHover = trim($this->pauseOnHover);

        $this->manualAdvance = trim($this->manualAdvance);

        $this->prevText = trim($this->prevText);
        if ($this->prevText == '') {
            $this->prevText = $this->_i18n['previous'];
        }
        $this->nextText = trim($this->nextText);
        if ($this->nextText == '') {
            $this->nextText = $this->_i18n['next'];
        }

        $this->beforeChange = trim($this->beforeChange);
        $this->afterChange = trim($this->afterChange);
        $this->slideshowEnd = trim($this->slideshowEnd);
        $this->lastSlide = trim($this->lastSlide);
        $this->afterLoad = trim($this->afterLoad);
    }

    /**
     * Generates the mpNivoSlider or a message on any occured error.
     */
    public function generateOutput()
    {
        if ($this->_sError !== '') {
            print $this->_sError;
            return;
        }

        $oTemplate = new Template();

        // get images
        $aImages = $this->_getImages();
        if (count($aImages) == 0) {
            print "mpNivoSlider: No images found in defined image folder!";
            return;
        }

        // list of image captions
        $aCaptions = array();

        // loop images array an fill template
        foreach ($aImages as $id => $image) {
            if ($this->controlNavThumbs && isset($image['thumb'])) {
                $image['attr'] = ' data-thumb="' . $image['thumb']['src'] . '"';
            }

            // store existing meta_description value in captions list
            if ($image['meta_description']) {
                $image['title'] = '#caption_' . $id;
                $aCaptions['caption_' . $id] = $image['meta_description'];
            }

            $oTemplate->set('d', 'IMG.SRC', $image['src']);
            $oTemplate->set('d', 'IMG.ALT', htmlspecialchars($image['alt']));
            $oTemplate->set('d', 'IMG.TITLE', $image['title']);
            $oTemplate->set('d', 'IMG.ATTRIBUTES', $image['attr']);
            $oTemplate->next();
        }

        // create captions markup
        $captions = '';
        if (!empty($aCaptions)) {
            $oCaptionsTpl = new Template();
            foreach ($aCaptions as $id => $text) {
                $oCaptionsTpl->set('d', 'ID', $id);
                $oCaptionsTpl->set('d', 'TEXT', $text);
                $oCaptionsTpl->next();
            }
            $captions = $oCaptionsTpl->generate(self::CAPTIONS_TPL, 1, 0);
        }
        $oTemplate->set('s', 'CAPTIONS', $captions);

        // js variables
        $jsVars = array();
        if ($this->effect) {
            $jsVars['effect'] = $this->effect;
        }
        if ($this->slices) {
            $jsVars['slices'] = $this->slices;
        }
        if ($this->boxCols) {
            $jsVars['boxCols'] = $this->boxCols;
        }
        if ($this->boxRows) {
            $jsVars['boxRows'] = $this->boxRows;
        }
        if ($this->animSpeed) {
            $jsVars['animSpeed'] = $this->animSpeed;
        }
        if ($this->pauseTime) {
            $jsVars['pauseTime'] = $this->pauseTime;
        }
        if (!empty($this->startSlide)) {
            $jsVars['startSlide'] = $this->startSlide;
        }
        $jsVars['directionNav'] = (bool) $this->directionNav;

        $jsVars['controlNav'] = (bool) $this->controlNav;
        $jsVars['controlNavThumbs'] = (bool) $this->controlNavThumbs;

        $jsVars['pauseOnHover'] = (bool) $this->pauseOnHover;
        $jsVars['manualAdvance'] = (bool) $this->manualAdvance;

        if ($this->prevText) {
            $jsVars['prevText'] = $this->prevText;
        }
        if ($this->nextText) {
            $jsVars['nextText'] = $this->nextText;
        }

        // we need a a special treatment for js functions
        $jsFuncs = array();
        if ($this->beforeChange) {
            $k = '#' . md5('beforeChange') . '#';
            $jsFuncs[$k] = 'function(){' . $this->beforeChange . '}';
            $jsVars['beforeChange'] = $k;
        }
        if ($this->afterChange) {
            $k = '#'. md5('afterChange') . '#';
            $jsFuncs[$k] = 'function(){' . $this->afterChange . '}';
            $jsVars['afterChange'] = $k;
        }
        if ($this->slideshowEnd) {
            $k = '#' . md5('slideshowEnd') . '#';
            $jsFuncs[$k] = 'function(){' . $this->slideshowEnd . '}';
            $jsVars['slideshowEnd'] = $k;
        }
        if ($this->lastSlide) {
            $k = '#' . md5('lastSlide') . '#';
            $jsFuncs[$k] = 'function(){' . $this->lastSlide . '}';
            $jsVars['lastSlide'] = $k;
        }
        if ($this->afterLoad) {
            $k = '#' . md5('afterLoad') . '#';
            $jsFuncs[$k] = 'function(){' . $this->afterLoad . '}';
            $jsVars['afterLoad'] = $k;
        }

        if (!empty($jsVars)) {
            $jsJson = json_encode($jsVars);
            if (!empty($jsFuncs)) {
                foreach ($jsFuncs as $k => $func) {
                    $jsJson = str_replace('"' . $k . '"', $func, $jsJson); 
                }
            }
        } else {
            $jsJson = '';
        }

        $oTemplate->set('s', 'NIVO.OPTIONS', $jsJson);

        // additional class names
        $cssClass = '';
        if ($this->darkImages) {
            $cssClass .= ' mpNivoSliderDark';
        }
        $oTemplate->set('s', 'MODULE.CLASSNAME', $cssClass);

        // additional styles
        $moduleStyle = '';
        if (is_numeric($this->maxWidth)) {
            $moduleStyle .= 'width:' . $this->maxWidth . 'px;';
        }
        if (is_numeric($this->maxHeight)) {
            $moduleStyle .= 'height:' . $this->maxHeight . 'px;';
        }
        $oTemplate->set('s', 'MODULE.STYLE', $moduleStyle);

		// slider wrapper css class
        $cssClass = '';
        if ($this->controlNavThumbs) {
            $cssClass .= ' controlnav-thumbs';
        }
        $oTemplate->set('s', 'MODULE.SLIDER.WRAPPER.CLASSNAME', $cssClass);

        $oTemplate->set('s', 'MODULE.UID', $this->getUid());

        $oTemplate->generate('templates/mpNivoSlider.html', 0, 0);
    }

    /**
     * Builds the images query statement, executes it and returns found images.
     *
     * @return array List of found images
     */
    protected function _getImages()
    {
        // where statement with selected dir and supported filetypes
        $aWhere = array();
        if ($this->useSubdirectories) {
            $aWhere[] = 'dirname LIKE "' . $this->selectedDirname . '%"';
        } else {
            $aWhere[] = 'dirname="' . $this->selectedDirname . '"';
        }
        $aWhere[] = 'AND';
        $aWhere[] = 'LOWER(filetype) IN(' . self::FILE_TYPES . ')';
        $sWhere = implode(' ', $aWhere);

        // order settings
        if (strpos($this->selectedOrder, ':') > 0) {
            list($sort, $sortdir) = explode(':', $this->selectedOrder);
            $sOrder = $sort . ' ' . $sortdir;
        } else {
            $sOrder = $this->selectedOrder;
        }

        // limit
        if ((int) $this->maxImages > 0) {
            $sLimit = '0, ' . $this->maxImages;
        } else {
            $sLimit = '';
        }

        // run the statement
        $oUploadColl = new UploadCollection();
        $oUploadColl->select($sWhere, '', $sOrder, $sLimit);

        $aImages = array();

        // iterate thru upload collection 2 store data in array
        while ($oUploadItem = $oUploadColl->next()) {
            // some checks
            $sImageFile = $this->_sAbsUploadPath . $oUploadItem->get('dirname') . $oUploadItem->get('filename');
            if (!is_file($sImageFile) || !is_readable($sImageFile)) {
                continue;
            }

            $aImgData = $this->_getImageData($sImageFile, $this->maxWidth, $this->maxHeight, $oUploadItem);
            if (!$aImgData) {
                continue;
            }
            if ($this->controlNavThumbs) {
                $aThumbData = $this->_getImageData($sImageFile, $this->controlNavThumbsWidthX, $this->controlNavThumbsHeightX, $oUploadItem);
                if ($aThumbData) {
                    $aImgData['thumb'] = $aThumbData;
                }
            }

            // add new images array item
            $aImages[$oUploadItem->get('idupl')] = $aImgData;
        }

        if (count($aImages) > 0) {
            // now get description by language
            $sWhere = 'idlang=' . $this->_lang . ' AND idupl IN(' . implode(', ', array_keys($aImages)) . ')';
            $oUploadMetaColl = new UploadMetaCollection();
            $oUploadMetaColl->select($sWhere, '', '');

            // iterate upload meta collection 2 store description in images array
            while ($oItem = $oUploadMetaColl->next()) {
                $aImages[$oItem->get('idupl')]['meta_description'] = $oItem->get('description');
            }
        }

        return $aImages;
    }

    /**
     * Returns image data structure. Resizes the image if needed.
     *
     * @param  string  $file  Path and file name
     * @param  string|int  $maxWidth  Max width, if bigger image has to be downsized
     * @param  string|int  $maxHeight  Max height, if bigger image has to be downsized
     * @param  object  Upload item object
     */
    protected function _getImageData($file, $maxWidth, $maxHeight, $oUploadItem)
    {
        if (is_numeric($maxWidth) && is_numeric($maxHeight)) {
            // get dimensions
            $size = $this->_getImageSize($file);

            // detect if images has to be downsized to a specific width or height
            // calculate also the downsize factor
            if ($size[0] / $size[1] > $maxWidth / $maxHeight) {
                $downsizeFactor = $maxWidth / $size[0];
            } else {
                $downsizeFactor = $maxHeight / $size[1];
            }

            // calculate dimensions
            $maxWidth = round($size[0] * $downsizeFactor);
            $maxHeight = round($size[1] * $downsizeFactor);

            // bigger images have 2 be resized
            $file = capiImgScale(
                $file, $maxWidth, $maxHeight, false, false, $this->maxCachetime, $this->imageQuality
            );
            if (!$file) {
                return null;
            }
            $file = str_replace($this->_sHtmlPath, '', $file);
        } else {
            // use original image file
            $file = $this->_sUploadDir . $oUploadItem->get('dirname') . $oUploadItem->get('filename');
        }

        // get'n store image dimensions
        $size = $this->_getImageSize($file);
        $attr = (is_array($size)) ? ' ' . $size[3] : '';

        // add new images array item
        return array(
            'size'  => $size,
            'src'   => $file,
            'alt'   => '',
            'title' => '',
            'attr'  => $attr,
            'meta_description' => '',
        );
    }

    /**
     * Returns value of getimagesize function, and also stores maximum width/height of
     * existing images.
     *
     * @param string Image file to ger size array for
     * @return array Returnvalue of getimagesize() function
     */
    protected function _getImageSize($file)
    {
        $size = @getimagesize($file);
        if (is_array($size)) {
            if ($this->_iCalculatedMaxWidth < $size[0]) {
                $this->_iCalculatedMaxWidth = $size[0];
            }
            if ($this->_iCalculatedMaxHeight < $size[1]) {
                $this->_iCalculatedMaxHeight = $size[1];
            }
        }
        return $size;
    }

    /**
     * Composes css definition 2 center a image horizontally and returns it back.
     *
     * @param mixed Array including image size imnformations (result of getimagesize())
     * @return string Composed css definition
     */
    protected function _css2centerImageHorizontal($size)
    {
        if (!is_array($size) || $this->_iCalculatedMaxHeight == 0 || ($size[1] == $this->_iCalculatedMaxHeight)) {
            return '';
        }
        $css = 'margin-top:' . (($this->_iCalculatedMaxHeight - $size[1]) / 2) . 'px';
        return $css;
    }

}
