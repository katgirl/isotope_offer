<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2011 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Kirsten Roschanski (C) 2012 
 * @author     Kirsten Roschanski 
 * @package    IsotopeOffer 
 * @license    LGPL 
 * @filesource
 */
 
 /**
 * -------------------------------------------------------------------------
 * Front end modules
 * -------------------------------------------------------------------------
 */
 
 $GLOBALS['FE_MOD']['isotope'] = array_merge($GLOBALS['FE_MOD']['isotope'], array
 (
	'iso_offer'					=> 'ModuleIsotopeOffer',
	'iso_offerhistory'		=> 'ModuleIsotopeOfferHistory',
	'iso_offerdetails'		=> 'ModuleIsotopeOfferDetails',
 ));

 /**
 * Offer Statuses
 */
 $GLOBALS['ISO_OFFER'] = array('pending', 'processing', 'complete', 'on_hold', 'cancelled');


 /**
  * Backend modules
  */
 if (!is_array($GLOBALS['BE_MOD']['isotope']))
 {
	array_insert($GLOBALS['BE_MOD'], 1, array('isotope' => array()));
 }

 array_insert($GLOBALS['BE_MOD']['isotope'], 2, array
 (
	'iso_offers' => array
	(
		'tables'					=> array('tl_iso_offers', 'tl_iso_offer_items'),
		'icon'					=> 'system/modules/isotope/html/shopping-basket.png',
		'javascript'			=> 'system/modules/isotope/html/backend.js',
		'export_emails'     	=> array('tl_iso_orders', 'exportOfferEmails'),
		'print_offer'			=> array('tl_iso_offers', 'printOffer'),
		'print_offers'			=> array('tl_iso_orders', 'printOffers'),
	),
 ));
 
if (TL_MODE == 'BE')
{
	$GLOBALS['TL_CSS'][] = 'system/modules/isotope_offer/html/backend.css';
}
 
?>
