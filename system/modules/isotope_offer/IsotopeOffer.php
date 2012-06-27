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
 
class IsotopeOffer extends IsotopeProductCollection
{

	/**
	 * Name of the current table
	 * @var string
	 */
	protected $strTable = 'tl_iso_offers';

	/**
	 * Name of the child table
	 * @var string
	 */
	protected $ctable = 'tl_iso_offer_items';

	/**
	 * This current offer's unique ID with eventual prefix
	 * @param string
	 */
	protected $strOfferId = '';

	/**
	 * Lock products from apply rule prices
	 * @var boolean
	 */
	protected $blnLocked = true;

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'iso_offer';


	/**
	 * Return a value
	 * @param string
	 * @return mixed
	 */
	public function __get($strKey)
	{
		$this->strTitle = $GLOBALS['TL_LANG']['MSC']['iso_offer_title'];		
		
		switch ($strKey)
		{	
			case 'order_id':
			case 'offer_id':
				return $this->strOfferId;

			case 'billingAddress':
				return deserialize($this->arrData['billing_address'], true);

			case 'shippingAddress':
				return deserialize($this->arrData['shipping_address'], true);

			default:
				return parent::__get($strKey);
		}
	}


	/**
	 * Set a value
	 * @param string
	 * @param mixed
	 * @throws Exception
	 */
	public function __set($strKey, $varValue)
	{
		switch ($strKey)
		{
			// Offer ID cannot be changed, it is created through IsotopeOffer::generateOfferId on checkout
			case 'offer_id':
				throw new Exception('IsotopeOffer offer_id cannot be changed trough __set().');
				break;

			default:
				parent::__set($strKey, $varValue);
		}
	}


	/**
	 * Find a record by its reference field and return true if it has been found
	 * @param string
	 * @param mixed
	 * @return boolean
	 */
	public function findBy($strRefField, $varRefId)
	{
		if (parent::findBy($strRefField, $varRefId))
		{
			// The offer_id must not be stored in arrData, or it would overwrite the database on save().
			$this->strOfferId = $this->arrData['offer_id'];
			unset($this->arrData['offer_id']);

			return true;
		}

		return false;
	}


	/**
	 * Return current surcharges as array
	 * @return array
	 */
	public function getSurcharges()
	{
		$arrSurcharges = deserialize($this->arrData['surcharges']);
		return is_array($arrSurcharges) ? $arrSurcharges : array();
	}


	/**
	 * Process the offer checkout
	 * @param object
	 * @return boolean
	 */
	public function checkout($objCart=null)
	{
		if ($this->checkout_complete)
		{
			return true;
		}

		$this->import('Isotope');

		// This is the case when not using ModuleIsotopeCheckout
		if (!is_object($objCart))
		{
			$objCart = new IsotopeCart();

			if (!$objCart->findBy('id', $this->cart_id))
			{
				$this->log('Cound not find Cart ID '.$this->cart_id.' for Offer ID '.$this->id, __METHOD__, TL_ERROR);
				return false;
			}

			// Set the current system to the language when the user placed the offer.
			// This will result in correct e-mails and payment description.
			$GLOBALS['TL_LANGUAGE'] = $this->language;
			$this->loadLanguageFile('default');

			// Initialize system
			$this->Isotope->overrideConfig($this->config_id);
			$this->Isotope->Cart = $objCart;
		}

		$arrItemIds = $this->transferFromCollection($objCart);
//		$objCart->delete();

		$this->checkout_complete = true;
		$this->status = $this->new_offer_status;
		$arrData = $this->email_data;
		$arrData['offer_id'] = $this->generateOfferId();

		foreach ($this->billing_address as $k => $v)
		{
			$arrData['billing_' . $k] = $this->Isotope->formatValue('tl_iso_addresses', $k, $v);
		}

		foreach ($this->shipping_address as $k => $v)
		{
			$arrData['shipping_' . $k] = $this->Isotope->formatValue('tl_iso_addresses', $k, $v);
		}

		if ($this->pid > 0)
		{
			$objUser = $this->Database->execute("SELECT * FROM tl_member WHERE id=" . (int) $this->pid);

			foreach ($objUser->row() as $k => $v)
			{
				$arrData['member_' . $k] = $this->Isotope->formatValue('tl_member', $k, $v);
			}
		}

		$this->log('New offer ID ' . $this->id . ' has been placed', 'IsotopeOffer checkout()', TL_ACCESS);

		if ($this->iso_mail_admin && $this->iso_sales_email != '')
		{
			$this->Isotope->sendMail($this->iso_mail_admin, $this->iso_sales_email, $this->language, $arrData, $this->iso_customer_email, $this);
		}

		if ($this->iso_mail_customer && $this->iso_customer_email != '')
		{
			$this->Isotope->sendMail($this->iso_mail_customer, $this->iso_customer_email, $this->language, $arrData, '', $this);
		}
		else
		{
			$this->log('Unable to send customer confirmation for offer ID '.$this->id, 'IsotopeOffer checkout()', TL_ERROR);
		}		
				
		$this->save();	
		return true;
	}


	/**
	 * Generate the next higher Offer-ID based on config prefix, offer number digits and existing records
	 * @return string
	 */
	private function generateOfferId()
	{
		if ($this->strOfferId != '')
		{
			return $this->strOfferId;
		}

		if ($this->strOfferId == '')
		{
			$strPrefix = $this->Isotope->Config->offerPrefix;
			$intPrefix = utf8_strlen($strPrefix);
			$arrConfigIds = $this->Database->execute("SELECT id FROM tl_iso_config WHERE store_id=" . $this->Isotope->Config->store_id)->fetchEach('id');
	
			// Lock tables so no other offer can get the same ID
			$this->Database->lockTables(array('tl_iso_offers'));
	
			// Retrieve the highest available offer ID
			$objMax = $this->Database->prepare("SELECT offer_id FROM tl_iso_offers WHERE " . ($strPrefix != '' ? "offer_id LIKE '$strPrefix%' AND " : '') . "config_id IN (" . implode(',', $arrConfigIds) . ") ORDER BY CAST(" . ($strPrefix != '' ? "SUBSTRING(offer_id, " . ($intPrefix+1) . ")" : 'offer_id') . " AS UNSIGNED) DESC")->limit(1)->executeUncached();
			$intMax = (int) substr($objMax->offer_id, $intPrefix);
			
			$this->strOfferId = $strPrefix . str_pad($intMax+1, $this->Isotope->Config->offerDigits, '0', STR_PAD_LEFT);
		}

		$this->Database->prepare("UPDATE tl_iso_offers SET offer_id=? WHERE id={$this->id}")->executeUncached($this->strOfferId);
		$this->Database->unlockTables();

		return $this->strOfferId;
	}
	
	/**
	 * Complete order if the checkout has been made. This will cleanup session data
	 */
	public function complete()
	{
		if ($this->checkout_complete)
		{
			$intConfig = $_SESSION['ISOTOPE']['config_id'];
			
			unset($_SESSION['CHECKOUT_DATA']);
			unset($_SESSION['ISOTOPE']);
			unset($_SESSION['FORM_DATA']);
			unset($_SESSION['FILES']);
			
			if ($intConfig > 0)
			{
				$_SESSION['ISOTOPE']['config_id'] = $intConfig;
			}

			return true;
		}
		
		return false;
	}	
}
