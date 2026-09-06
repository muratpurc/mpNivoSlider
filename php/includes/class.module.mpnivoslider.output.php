<?php

namespace Purc\Module\MpNivoSlider;

use cApiModule;
use cApiUpload;
use cApiUploadCollection;
use cApiUploadMetaCollection;
use cDbException;
use cException;
use cInvalidArgumentException;

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

defined('CON_FRAMEWORK') || die('Illegal call!');

include_once __DIR__ . '/class.module.mpnivoslider.baseabstract.php';

/**
 * CONTENIDO module output class for mpNivoSlider
 *
 * @property mixed calculatedMaxHeight
 * @property mixed calculatedMaxWidth
 */
class Output extends BaseAbstract
{

    /**
     * To store occurred errors
     */
    protected string $error = '';

    /**
     * {@inheritdoc}
     */
    protected function validate(): void
    {
        // Directory including images 4 the slider
        $this->selectedDirname = trim($this->selectedDirname);
        if ($this->selectedDirname == '') {
            $this->error = "mpNivoSlider: No image folder selected!";
            return;
        } elseif (!is_dir($this->uploadDir . $this->selectedDirname)) {
            $this->error = "mpNivoSlider: Selected image folder doesn't exists anymore!";
            return;
        }

        $allowedEffects = ',' . self::EFFECTS . ',';
        $configuredEffects = explode(',', trim($this->effect));
        $cleanedEffects = [];
        foreach ($configuredEffects as $effect) {
            if (str_contains($allowedEffects, ',' . $effect . ',')) {
                $cleanedEffects[] = $effect;
            }
        }
        $this->effect = implode(',', $cleanedEffects);

        parent::validate();

        // Selected order type
        if (!isset($this->order[$this->selectedOrder])) {
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
            $this->prevText = $this->i18n['previous'];
        }
        if ($this->nextText == '') {
            $this->nextText = $this->i18n['next'];
        }
    }

    /**
     * Generates the view data.
     */
    public function getViewData(): array
    {
        $viewData = [];
        $viewData['error'] = '';

        if ($this->error !== '') {
            $viewData['error'] = $this->error;
            return $viewData;
        }

        try {
            $cApiModule = new cApiModule($this->idmod);
        } catch (cDbException|cException $e) {
            cError(__CLASS__ . ': Could not get view data: ' . $e->getMessage());
            $viewData['error'] = 'mpNivoSlider: No images found in defined image folder!';
            return $viewData;
        }

        if ($this->isBackend) {
            $viewData['modulePath'] = $this->clientCfg['path']['htmlpath'] . $this->modulePath . $cApiModule->get('alias');
        } else {
            $viewData['modulePath'] = $this->modulePath . $cApiModule->get('alias');
        }

        // Get images
        try {
            $images = $this->getImages();
        } catch (cDbException|cException $e) {
            cError(__CLASS__ . ': Could not get view data: ' . $e->getMessage());
            $viewData['error'] = 'mpNivoSlider: No images found in defined image folder!';
            return $viewData;
        }
        if (count($images) == 0) {
            $viewData['error'] = 'mpNivoSlider: No images found in defined image folder!';
            return $viewData;
        }

        // List of images and image captions
        $dataImages = [];
        $dataCaptions = [];

        // Loop images array and fill template
        foreach ($images as $id => $image) {
            if ($this->controlNavThumbs && isset($image['thumb'])) {
                $image['attr'] = ' data-thumb="' . $image['thumb']['src'] . '"';
            }

            // Store existing meta_description value in captions list
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

        // JavaScript variables
        $jsVars = [];
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
        $jsVars['directionNav'] = (bool)$this->directionNav;

        $jsVars['controlNav'] = (bool)$this->controlNav;
        $jsVars['controlNavThumbs'] = (bool)$this->controlNavThumbs;

        $jsVars['pauseOnHover'] = (bool)$this->pauseOnHover;
        $jsVars['manualAdvance'] = (bool)$this->manualAdvance;

        if ($this->prevText) {
            $jsVars['prevText'] = $this->prevText;
        }
        if ($this->nextText) {
            $jsVars['nextText'] = $this->nextText;
        }

        // We need a special treatment for js functions
        $jsFuncs = [];
        if ($this->beforeChange) {
            $k = '#' . md5('beforeChange') . '#';
            $jsFuncs[$k] = 'function(){' . $this->beforeChange . '}';
            $jsVars['beforeChange'] = $k;
        }
        if ($this->afterChange) {
            $k = '#' . md5('afterChange') . '#';
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

        // Additional class names
        $cssClass = '';
        if ($this->darkImages) {
            $cssClass .= ' mpNivoSliderDark';
        }
        $viewData['cssClassName'] = $cssClass;

        // Additional styles
        $moduleStyle = '';
        if (!$this->responsiveMode) {
            // Add module dimensions only if responsive mode is off
            if (is_numeric($this->maxWidth)) {
                $moduleStyle .= 'width:' . $this->maxWidth . 'px;';
            }
            if (is_numeric($this->maxHeight)) {
                $moduleStyle .= 'height:' . $this->maxHeight . 'px;';
            }
        }
        $viewData['styles'] = $moduleStyle;

        // Slider wrapper css class
        $cssClass = '';
        if ($this->controlNavThumbs) {
            $cssClass .= ' controlnav-thumbs';
        }
        $viewData['sliderWrapperCssClassName'] = $cssClass;

        $viewData['uid'] = $this->getUid();

        return $viewData;
    }

    /**
     * Returns image data structure. Resizes the image if needed.
     *
     * @param string $file Path and file name
     * @param string|int $maxWidth Max width, if bigger image has to be downsized
     * @param string|int $maxHeight Max height, if bigger image has to be downsized
     * @param cApiUpload $uploadItem Upload item object
     */
    protected function getImageData(string $file, mixed $maxWidth, mixed $maxHeight, cApiUpload $uploadItem): array
    {
        if (is_numeric($maxWidth) && is_numeric($maxHeight)) {
            // Get dimensions
            $size = $this->getImageSize($file);

            // Detect if images have to be downsized to a specific width or height
            // calculate also the downsized factor
            if ($size[0] / $size[1] > $maxWidth / $maxHeight) {
                $downsizeFactor = $maxWidth / $size[0];
            } else {
                $downsizeFactor = $maxHeight / $size[1];
            }

            // Prevent scaling up of small images
            if ($downsizeFactor > 1) {
                $downsizeFactor = 1;
            }

            // Calculate dimensions
            $maxWidth = round($size[0] * $downsizeFactor);
            $maxHeight = round($size[1] * $downsizeFactor);

            // Bigger images have 2 be resized
            try {
                $file = capiImgScale(
                    $file,
                    $maxWidth,
                    $maxHeight,
                    false,
                    false,
                    $this->maxCacheTime,
                    $this->imageQuality
                );
            } catch (cDbException|cInvalidArgumentException|cException $e) {
                cError(__CLASS__ . ': Could not scale image: ' . $e->getMessage());
                return [];
            }
            if (!$file) {
                return [];
            }
            $file = str_replace($this->htmlPath, '', $file);
        } else {
            // Use original image file
            $file = $this->uploadDir . $uploadItem->get('dirname') . $uploadItem->get('filename');
        }

        // Get'n'store image dimensions, but save width/height attributes only for disabled responsive mode
        $size = $this->getImageSize($file);
        $attr = (is_array($size) && !$this->responsiveMode) ? ' ' . $size[3] : '';

        // Add new images array item
        return [
            'size' => $size,
            'src' => $file,
            'alt' => '',
            'title' => '',
            'attr' => $attr,
            'meta_description' => '',
        ];
    }

    /**
     * Builds the image query statement, executes it, and returns found images.
     *
     * @return array List of found images
     * @throws cDbException|cException
     */
    protected function getImages(): array
    {
        $uploadColl = new cApiUploadCollection();

        // WHERE statement with selected dir and supported filetypes
        $where = [];
        if ($this->useSubdirectories) {
            $where[] = "`dirname` LIKE '" . $uploadColl->escape($this->selectedDirname) . "%'";
        } else {
            $where[] = "`dirname` = '" . $uploadColl->escape($this->selectedDirname) . "'";
        }
        $where[] = 'AND';
        $where[] = 'LOWER(`filetype`) IN(' . self::FILE_TYPES . ')';
        $where = implode(' ', $where);

        // Order settings
        if (strpos($this->selectedOrder, ':') > 0) {
            list($sort, $sortDir) = explode(':', $this->selectedOrder);
            $sOrder = $uploadColl->escape($sort) . ' ' . $uploadColl->escape($sortDir);
        } else {
            $sOrder = $uploadColl->escape($this->selectedOrder);
        }

        // Limit
        $limit = ((int)$this->maxImages > 0) ? '0, ' . $this->maxImages : '';

        // Run the statement
        $uploadColl->select($where, '', $sOrder, $limit);

        $images = [];

        // Iterate through upload collection 2 store data in array
        while ($uploadItem = $uploadColl->next()) {
            // Some checks
            $sImageFile = $this->absUploadPath . $uploadItem->get('dirname') . $uploadItem->get('filename');
            if (!is_file($sImageFile) || !is_readable($sImageFile)) {
                continue;
            }

            $aImgData = $this->getImageData($sImageFile, $this->maxWidth, $this->maxHeight, $uploadItem);
            if (!$aImgData) {
                continue;
            }
            if ($this->controlNavThumbs) {
                $aThumbData = $this->getImageData(
                    $sImageFile,
                    $this->controlNavThumbsWidthX,
                    $this->controlNavThumbsHeightX,
                    $uploadItem
                );
                if ($aThumbData) {
                    $aImgData['thumb'] = $aThumbData;
                }
            }

            // Add new images array item
            $images[$uploadItem->get('idupl')] = $aImgData;
        }

        if (count($images) > 0) {
            // Now get description by language
            $uploadMetaColl = new cApiUploadMetaCollection();
            $uploadMetaColl->select(
                '`idlang` = ' . $this->lang . ' AND `idupl` IN(' . implode(', ', array_keys($images)) . ')'
            );

            // Iterate through upload meta collection 2 store description in images array
            while ($oItem = $uploadMetaColl->next()) {
                $images[$oItem->get('idupl')]['meta_description'] = $oItem->get('description');
            }
        }

        return $images;
    }

    /**
     * Returns value of getimagesize function and also stores the maximum width / height of
     * existing images.
     *
     * @param string $file Image file to get the size array for
     * @return array|false Return value of getimagesize() function
     */
    protected function getImageSize(string $file): bool|array
    {
        $size = @getimagesize($file);
        if (is_array($size)) {
            if ($this->calculatedMaxWidth < $size[0]) {
                $this->calculatedMaxWidth = $size[0];
            }
            if ($this->calculatedMaxHeight < $size[1]) {
                $this->calculatedMaxHeight = $size[1];
            }
        }
        return $size;
    }

    /**
     * Composes css definition 2 center an image horizontally and returns it back.
     *
     * @param mixed $size Array including image size information (result of getimagesize())
     * @return string Composed css definition
     */
    protected function css2centerImageHorizontal(mixed $size): string
    {
        if (!is_array($size) || $this->calculatedMaxHeight == 0 || ($size[1] == $this->calculatedMaxHeight)) {
            return '';
        }
        return 'margin-top:' . (($this->calculatedMaxHeight - $size[1]) / 2) . 'px';
    }

}
