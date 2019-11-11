<?php
/**
 * Project:
 * CONTENIDO Content Management System
 *
 * Description:
 * CONTENIDO module input class for mpNivoSlider
 *
 * Requirements:
 * @con_php_req 5.0
 *
 * @package     CONTENIDO_Modules
 * @subpackage  mpNivoSlider
 * @author      Murat Purc <murat@purc.de>
 * @copyright   Copyright (c) 2011-2013 Murat Purc (http://www.purc.de)
 * @license     http://www.gnu.org/licenses/gpl-2.0.html - GNU General Public License, version 2
 * @version     $Id: class.module.mpnivoslider.input.php 34 2013-11-14 19:53:12Z murat $
 */


if (!defined('CON_FRAMEWORK')) {
    die('Illegal call');
}

cInclude('frontend', 'includes/class.module.mpnivoslider.php');


/**
 * CONTENIDO module input class for mpNivoSlider
 */
class ModuleMpNivoSliderInput extends ModuleMpNivoSliderAbstract
{

    /**
     * Generates and returns option items of the dirname select box.
     *
     * @return  string  Composed option items.
     */
    public function generateDirSelectOptions()
    {
        $oUploadColl = new UploadCollection();
        $oUploadColl->flexSelect('dirname', '', 'idclient=' . $this->_client, 'dirname');

        $opt = '<option value="">' . $this->_i18n['__select_folder__'] . '</option>' . "\n";
        while ($oUploadItem = $oUploadColl->next()) {
            $dirname = $oUploadItem->get('dirname');

            $sel = ($dirname == $this->selectedDirname) ? ' selected="selected"' : '';
            $opt .= '<option value="' . $dirname . '"' . $sel . '>' . $dirname . '</option>' . "\n";
        }
        return $opt;
    }

    /**
     * Generates and returns option items of the order select box.
     *
     * @return  string  Composed option items.
     */
    public function generateOrderSelectOptions()
    {
        $opt = '<option value="">' . $this->_i18n['__select_order__'] . '</option>' . "\n";
        foreach ($this->_aOrder as $key => $value) {
            $sel = ($key == $this->selectedOrder) ? ' selected="selected"' : '';
            $opt .= '<option value="' . $key . '"' . $sel . '>' . $value . '</option>' . "\n";
        }
        return $opt;
    }

    /**
     * {@inheritdoc}
     */
    protected function _validate()
    {
        $this->useSubdirectories = trim($this->useSubdirectories);

        $this->maxImages = (int) $this->maxImages;
        if ($this->maxImages <= 1) {
            $this->maxImages = '';
        }

        $this->maxWidth = (int) $this->maxWidth;
        if ($this->maxWidth <= 0) {
            $this->maxWidth = '';
        }

        $this->maxHeight = (int) $this->maxHeight;
        if ($this->maxHeight <= 0) {
            $this->maxHeight = '';
        }

		if ($this->imageQuality < 0 || $this->imageQuality > 100) {
			$this->imageQuality = self::DEFAULT_QUALITY;
		}

        $this->responsiveMode = (int) $this->responsiveMode;
		if ($this->responsiveMode < 0) {
			$this->responsiveMode = '';
		}

        $this->maxCachetime = (int) $this->maxCachetime;
        if ($this->maxCachetime < 0) {
            $this->maxCachetime = '';
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
        if ($this->controlNavThumbsWidthX <= 0) {
            $this->controlNavThumbsWidthX = '';
        }
        $this->controlNavThumbsHeightX = (int) $this->controlNavThumbsHeightX;
        if ($this->controlNavThumbsHeightX <= 0) {
            $this->controlNavThumbsHeightX = '';
        }

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

}
