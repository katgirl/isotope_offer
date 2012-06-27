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


// Palettes
$GLOBALS['TL_DCA']['tl_iso_config']['palettes']['default'] = str_replace
(
    'orderDigits,',
    'orderDigits,offerPrefix,offerDigits,',
    $GLOBALS['TL_DCA']['tl_iso_config']['palettes']['default']
);

// Fields
$GLOBALS['TL_DCA']['tl_iso_config']['fields']['offerPrefix'] = array
(
	  'label'           => &$GLOBALS['TL_LANG']['tl_iso_config']['offerPrefix'],
	  'exclude'         => true,
	  'inputType'       => 'text',
	  'eval'            => array('maxlength'=>5, 'decodeEntities'=>true, 'tl_class'=>'w50'),
);

$GLOBALS['TL_DCA']['tl_iso_config']['fields']['offerDigits'] = array
(
	  'label'           => &$GLOBALS['TL_LANG']['tl_iso_config']['offerDigits'],
	  'exclude'         => true,
	  'default'				  => 4,
	  'inputType'       => 'select',
	  'options'				  => range(1, 9),
	  'eval'            => array('tl_class'=>'w50'),
);
