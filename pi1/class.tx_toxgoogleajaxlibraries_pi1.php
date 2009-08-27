<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2009 Enrico Hoffmann <dasrick@gmail.com>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 * Hint: use extdeveval to insert/update function index above.
 */

require_once(PATH_tslib.'class.tslib_pibase.php');


/**
 * Plugin 'tox | Google AJAX Libraries' for the 'tox_googleajaxlibraries' extension.
 *
 * @author	Enrico Hoffmann <dasrick@gmail.com>
 * @package	TYPO3
 * @subpackage	tx_toxgoogleajaxlibraries
 */
class tx_toxgoogleajaxlibraries_pi1 extends tslib_pibase {
	var $prefixId		= 'tx_toxgoogleajaxlibraries_pi1';					// Same as class name
	var $scriptRelPath	= 'pi1/class.tx_toxgoogleajaxlibraries_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey			= 'tox_googleajaxlibraries';						// The extension key.
	var $pi_checkCHash	= true;
	var $libKeys		= array('jquery','jqueryui','prototype','scriptaculous','mootools','dojo','swfobject','yui','ext-core');

	/**
	 * The main method of the PlugIn
	 *
	 * @access	public
	 * @param	string		$content: The PlugIn content
	 * @param	array		$conf: The PlugIn configuration
	 * @return	The content that is displayed on the website
	 */
	public function main($content, $conf)	{
		$this->conf	= $conf;
		$usedLibs	= $this->_getUsedLibs();
		if (!empty($usedLibs)) {
			$this->_insertJSapicode();
			$this->_insertJSlibcode($usedLibs);
		}
	}

	/**
	 * 
	 * @access	private
	 * @return	array $usedLibs	The used JS-Libraries
	 */
	private function _getUsedLibs() {
		$usedLibs	= array();
		foreach ($this->conf as $cKey=>$cValue) {
			if (in_array($cKey, $this->libKeys)) {
				if (!empty($cValue)) {
					$usedLibs[$cKey]	= $cValue;
				}
			}
		}
		return $usedLibs;
	}

	/**
	 * Insert google-jsapi-script into head
	 * 
	 * @access	private
	 * @return	void
	 */
	private function _insertJSapicode() {
		$urlParam = (!empty($this->conf['googleapikey'])) ? $urlParam = '?key='.$this->conf['googleapikey'] : '';
		$GLOBALS['TSFE']->additionalHeaderData[$this->extKey.'googleapikey'] = '<script type="text/javascript" src="http://www.google.com/jsapi'.$urlParam.'"></script>';
	}

	/**
	 * Insert goole.load-script into head
	 * 
	 * @access	private
	 * @param	array	$usedLibs	The used Libraries
	 * @return	void
	 */
	private function _insertJSlibcode($usedLibs) {
		foreach ($usedLibs as $libKey=>$libValue) {
			$GLOBALS['TSFE']->additionalHeaderData[$this->extKey.$libKey] = '<script type="text/javascript">google.load("'.$libKey.'", "'.$libValue.'");</script>';
		}
	}
}


if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/tox_googleajaxlibraries/pi1/class.tx_toxgoogleajaxlibraries_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/tox_googleajaxlibraries/pi1/class.tx_toxgoogleajaxlibraries_pi1.php']);
}

?>