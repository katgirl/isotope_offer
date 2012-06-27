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
 * @package    IsotopeCreateOffer 
 * @license    LGPL 
 * @filesource
 */

/**
 * -------------------------------------------------------------------------
 * HOOKS
 * -------------------------------------------------------------------------
 *
 * Hooking allows you to register one or more callback functions that are 
 * called on a particular event in a specific order. Thus, third party 
 * extensions can add functionality to the core system without having to
 * modify the source code.
 */ 
 
 $GLOBALS['TL_HOOKS']['processFormData'][] = array('IsotopeCreateOffer', 'myProcessFormData');
 $GLOBALS['TL_HOOKS']['outputTemplate'][] = array('IsotopeCreateOffer', 'myOutputFrontendTemplate');

/**
 * -------------------------------------------------------------------------
 * PAGE TYPES
 * -------------------------------------------------------------------------
 *
 * Page types and their corresponding front end controller class.
 */
 
 $GLOBALS['TL_ICO']['email'] = 'office@cupprint.de';
 $GLOBALS['TL_ICO']['form']  = 'auto_offer_contact_data'; 
 $GLOBALS['TL_ICO']['site_offer']  = 'send_offer_per_mail';
 $GLOBALS['TL_ICO']['site_order']  = 'send_order_per_mail';
?>
