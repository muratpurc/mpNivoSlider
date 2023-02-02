<?php
/**
 * Project:
 * CONTENIDO Content Management System
 *
 * Description:
 * CONTENIDO module output class for mpNivoSlider
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

include_once('class.module.mpnivoslider.php');


/**
 * CONTENIDO module output class for mpNivoSlider
 *
 * @property mixed _iCalculatedMaxHeight
 * @property mixed _iCalculatedMaxWidth
 */
class ModuleMpNivoSliderOutput extends ModuleMpNivoSliderAbstract
{
    /**
     * To store occurred errors
     * @var  string
     */
    protected $_sError = '';


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

        $allowedEffects = ',' . self::EFFECTS . ',';
        $configuredEffects = explode(',', trim($this->effect));
        $cleanedEffects = array();
        foreach ($configuredEffects as $effect) {
            if (strpos($allowedEffects, ',' . $effect . ',') !== false) {
                $cleanedEffects[] = $effect;
            }
        }
        $this->effect = implode(',', $cleanedEffects);

        parent::_validate();

        // selected order type
        if (!isset($this->_aOrder[$this->selectedOrder])) {
            $this->selectedOrder = 'filename:ASC';
        }

        if ($this->controlNavThumbs) {
            if ($this->controlNavThumbsHeightX <= 0) {
                $this->controlNavThumbsHeightX = 50;
            }
            if ($this->controlNavThumbsWidthX <= 0) {
                $this->controlNavThumbsWidthX = 70;
            }
        }

        if ($this->prevText == '') {
            $this->prevText = $this->_i18n['previous'];
        }
        if ($this->nextText == '') {
            $this->nextText = $this->_i18n['next'];
        }
    }

    /**
     * Generates the view data.
     * @return array
     */
    public function getViewData()
    {
        $viewData = [];
        $viewData['error'] = '';

        if ($this->_sError !== '') {
            $viewData['error'] = $this->_sError;
            return $viewData;
        }

        $cApiModule = new cApiModule($this->idmod);
        $viewData['modulePath'] = $this->_sModulePath . $cApiModule->get('alias');

        // get images
        $aImages = $this->_getImages();
        if (count($aImages) == 0) {
            $viewData['error'] = 'mpNivoSlider: No images found in defined image folder!';
            return $viewData;
        }

        // list of images and image captions
        $dataImages = [];
        $dataCaptions = [];

        // loop images array an fill template
        foreach ($aImages as $id => $image) {
            if ($this->controlNavThumbs && isset($image['thumb'])) {
                $image['attr'] = ' data-thumb="' . $image['thumb']['src'] . '"';
            }

            // store existing meta_description value in captions list
            if ($image['meta_description']) {
                $image['title'] = '#caption_' . $id;
                $dataCaptions[] = [
                    'id' => 'caption_' . $id,
                    'text' => $image['meta_description']
                ];
            }

            $dataImages[] = [
                'src' => $image['src'],
                'alt' => $image['alt'],
                'title' => $image['title'],
                'attributes' => $image['attr']
            ];
        }

        $viewData['images'] = $dataImages;
        $viewData['captions'] = $dataCaptions;

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

        $viewData['nivoOptions'] = $jsJson;

        // additional class names
        $cssClass = '';
        if ($this->darkImages) {
            $cssClass .= ' mpNivoSliderDark';
        }
        $viewData['cssClassName'] = $cssClass;

        // additional styles
        $moduleStyle = '';
        if (!$this->responsiveMode) {
            // add module dimensions only if responsive mode is off
            if (is_numeric($this->maxWidth)) {
                $moduleStyle .= 'width:' . $this->maxWidth . 'px;';
            }
            if (is_numeric($this->maxHeight)) {
                $moduleStyle .= 'height:' . $this->maxHeight . 'px;';
            }
        }
        $viewData['styles'] = $moduleStyle;

        // slider wrapper css class
        $cssClass = '';
        if ($this->controlNavThumbs) {
            $cssClass .= ' controlnav-thumbs';
        }
        $viewData['sliderWrapperCssClassName'] = $cssClass;

        $viewData['uid'] = $this->getUid();

        return $viewData;
    }

    /**
     * Builds the images query statement, executes it and returns found images.
     *
     * @return array List of found images
     */
    protected function _getImages()
    {
        $oUploadColl = new cApiUploadCollection();

        // where statement with selected dir and supported filetypes
        $aWhere = array();
        if ($this->useSubdirectories) {
            $aWhere[] = "dirname LIKE '" . $oUploadColl->escape($this->selectedDirname) . "%'";
        } else {
            $aWhere[] = "dirname='" . $oUploadColl->escape($this->selectedDirname) . "'";
        }
        $aWhere[] = 'AND';
        $aWhere[] = 'LOWER(filetype) IN(' . self::FILE_TYPES . ')';
        $sWhere = implode(' ', $aWhere);

        // order settings
        if (strpos($this->selectedOrder, ':') > 0) {
            list($sort, $sortDir) = explode(':', $this->selectedOrder);
            $sOrder = $oUploadColl->escape($sort) . ' ' . $oUploadColl->escape($sortDir);
        } else {
            $sOrder = $oUploadColl->escape($this->selectedOrder);
        }

        // limit
        if ((int) $this->maxImages > 0) {
            $sLimit = '0, ' . $this->maxImages;
        } else {
            $sLimit = '';
        }

        // run the statement
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
            $oUploadMetaColl = new cApiUploadMetaCollection();
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
     * @return array
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

            // prevent scalip up of small images
            if ($downsizeFactor > 1) {
                $downsizeFactor = 1;
            }

            // calculate dimensions
            $maxWidth = round($size[0] * $downsizeFactor);
            $maxHeight = round($size[1] * $downsizeFactor);

            // bigger images have 2 be resized
            $file = capiImgScale(
                $file, $maxWidth, $maxHeight, false, false, $this->maxCacheTime, $this->imageQuality
            );
            if (!$file) {
                return null;
            }
            $file = str_replace($this->_sHtmlPath, '', $file);
        } else {
            // use original image file
            $file = $this->_sUploadDir . $oUploadItem->get('dirname') . $oUploadItem->get('filename');
        }

        // get'n store image dimensions, but save width/height attributes only for disabled responsive mode
        $size = $this->_getImageSize($file);
        $attr = (is_array($size) && !$this->responsiveMode) ? ' ' . $size[3] : '';

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
     * @return array Return value of getimagesize() function
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
     * @param mixed Array including image size information (result of getimagesize())
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
