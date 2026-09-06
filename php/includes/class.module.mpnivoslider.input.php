<?php

namespace Purc\Module\MpNivoSlider;

use cApiUploadCollection;
use cDbException;
use cException;

/**
 * Project:
 * CONTENIDO Content Management System
 *
 * Description:
 * CONTENIDO module input class for mpNivoSlider
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
 * CONTENIDO module input class for mpNivoSlider
 */
class Input extends BaseAbstract
{

    /**
     * Generates and returns option items of the dirname select box.
     *
     * @return string Composed option items.
     * @throws cDbException|cException
     */
    public function generateDirSelectOptions(): string
    {
        $oUploadColl = new cApiUploadCollection();
        $oUploadColl->flexSelect('dirname', '', '`idclient` = ' . $this->client, 'dirname');

        $opt = '<option value="">' . $this->i18n['__select_folder__'] . '</option>' . "\n";
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
     * @return string Composed option items.
     */
    public function generateOrderSelectOptions(): string
    {
        $opt = '<option value="">' . $this->i18n['__select_order__'] . '</option>' . "\n";
        foreach ($this->order as $key => $value) {
            $sel = ($key == $this->selectedOrder) ? ' selected="selected"' : '';
            $opt .= '<option value="' . $key . '"' . $sel . '>' . $value . '</option>' . "\n";
        }
        return $opt;
    }

    /**
     * {@inheritdoc}
     */
    protected function validate(): void
    {
        parent::validate();

        if ($this->controlNavThumbsWidthX <= 0) {
            $this->controlNavThumbsWidthX = '';
        }

        if ($this->controlNavThumbsHeightX <= 0) {
            $this->controlNavThumbsHeightX = '';
        }
    }

}
