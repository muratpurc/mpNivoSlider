<?php

/**
 * Project: 
 * CONTENIDO Content Management System
 * 
 * Description: 
 * Upload meta data item and item collection.
 * NOTE:
 * This file doesn't belongs to official CONTENIDO core, is just a addon to eliminate usage of manual
 * generated sql statements in modules...
 * 
 * Requirements: 
 * @con_php_req 5.0
 * 
 *
 * @package    CONTENIDO Backend classes
 * @version    0.2
 * @author     Murat Purc
 * @copyright  four for business AG <www.4fb.de>
 * @license    http://www.contenido.org/license/LIZENZ.txt
 * @link       http://www.4fb.de
 * @link       http://www.contenido.org
 * 
 * {@internal 
 *   created 2008-09-27, Murat Purc
 *   $Id: class.uploadmeta.php 1 2012-01-06 22:28:28Z murat $
 * }}
 * 
 */

if (!defined('CON_FRAMEWORK')) {
	die('Illegal call');
}

cInclude('classes', 'class.dbfs.php');


class UploadMetaCollection extends ItemCollection
{
	/**
     * Constructor function
     */
	public function __construct()
	{
		global $cfg;
		parent::__construct($cfg['tab']['upl_meta'], 'id_uplmeta');
        $this->_setItemClass('UploadMeta');
	}

	public function create($idupl, $idlang, $medianame, $description, $keywords, $internal_notice)
	{
		global $auth;

		$item = parent::create();

		$item->set('idupl', $idupl, false);
		$item->set('idlang', $idlang, false);
		$item->set('medianame', $medianame, false);
		$item->set('description', $description, false);
		$item->set('keywords', $keywords, false);
		$item->set('internal_notice', $internal_notice, false);
		$item->set('author', $auth->auth['uid']);
		$item->set('created', date('Y-m-d H:i:s'),false);
		$item->store();

		$item->update();

		return ($item);	
	}

	public function loadItem($itemID)
	{
		$item = new UploadMeta();
		$item->loadByPrimaryKey($itemID);
		return ($item);
	}

	public function delete($id)
	{
		return parent::delete($id);
	}
}


class UploadMeta extends Item
{

	/**
     * Constructor function
     * @param  mixed  $mId  Specifies the ID of item to load
     */
    public function __construct($mId = false)
	{
		global $cfg;
		parent::__construct($cfg['tab']['upl_meta'], 'id_uplmeta');
        if ($mId !== false) {
            $this->loadByPrimaryKey($mId);
        }
	}


	public function store()
	{
		global $auth;
        $this->set('modified', date('Y-m-d H:i:s'),false);
		$this->set('modifiedby', $auth->auth['uid']);
		parent::store();	
	}

}

