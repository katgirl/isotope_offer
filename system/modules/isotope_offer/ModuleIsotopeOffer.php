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
 * Class ModuleIsotopeOffer
 * Front end module Isotope "offer".
 */
class ModuleIsotopeOffer extends ModuleIsotope
{

	/**
	 * Offer data. Each checkout step can provide key-value (string) data for the offer email.
	 * @var array
	 */
	public $arrOfferData = array();

	/**
	 * Disable caching of the frontend page if this module is in use.
	 * @var boolean
	 */
	protected $blnDisableCache = true;


	/**
	 * Display a wildcard in the back end
	 * @return string
	 */
	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new BackendTemplate('be_wildcard');

			$objTemplate->wildcard = '### ISOTOPE OFFER ###';
			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
			$objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

			return $objTemplate->parse();
		}
		
		return parent::generate();
	}


	/**
	 * Generate module
	 * @return void
	 */
	protected function compile()
	{
		// Return error message if cart is empty
		if (!$this->Isotope->Cart->items)
		{
			$this->Template = new FrontendTemplate('mod_message');
			$this->Template->type = 'empty';
			$this->Template->message = $GLOBALS['TL_LANG']['MSC']['noItemsInCart'];
			return;
		}

		// Insufficient cart subtotal
		if ($this->Isotope->Config->cartMinSubtotal > 0 && $this->Isotope->Config->cartMinSubtotal > $this->Isotope->Cart->subTotal)
		{
			$this->Template = new FrontendTemplate('mod_message');
			$this->Template->type = 'error';
			$this->Template->message = sprintf($GLOBALS['TL_LANG']['ERR']['cartMinSubtotal'], $this->Isotope->formatPriceWithCurrency($this->Isotope->Config->cartMinSubtotal));
			return;
		}

		if($_SESSION['FORM_DATA']) 
		{					
			$this->writeOffer();		
		}
		
	}
	
	/**
	 * Save the offer
	 * @return void
	 */	
	protected function writeOffer()
	{
		$objOffer = new IsotopeOffer();

//		if (!$objOffer->findBy('cart_id', $this->Isotope->Cart->id))
//		{
			$objOffer->uniqid		= uniqid($this->Isotope->Config->offerPrefix, true);
			$objOffer->cart_id		= $this->Isotope->Cart->id;
			$objOffer->findBy('id', $objOffer->save());
//		}
		// Isotope has Street as Street_1
		$_SESSION['FORM_DATA']['street_1'] = $_SESSION['FORM_DATA']['street'];
		
		$strBillingAddress = $this->Isotope->generateAddressString($_SESSION['FORM_DATA'], $this->Isotope->Config->billing_fields);		
		$this->arrOfferData['billing_address']		= $strBillingAddress;
		$this->arrOfferData['billing_address_text']	= strip_tags(str_replace(array('<br />', '<br>'), "\n", $strBillingAddress));	

		$objOffer->date				= time();
		$objOffer->pid 				= (int) $this->User->id;
		$objOffer->config_id		= (int) $this->Isotope->Config->id;
		$objOffer->subTotal			= $this->Isotope->Cart->subTotal;
		$objOffer->taxTotal			= $this->Isotope->Cart->taxTotal;
		$objOffer->shippingTotal	= $this->Isotope->Cart->shippingTotal;
		$objOffer->grandTotal		= $this->Isotope->Cart->grandTotal;
		$objOffer->surcharges		= $this->Isotope->Cart->getSurcharges();
		$objOffer->language			= $GLOBALS['TL_LANGUAGE'];
		$objOffer->billing_address	= $_SESSION['FORM_DATA'];
		$objOffer->shipping_address	= $_SESSION['FORM_DATA'];
		$objOffer->currency				= $this->Isotope->Config->currency;
		$objOffer->iso_sales_email		= $this->iso_sales_email ? $this->iso_sales_email : (($GLOBALS['TL_ADMIN_NAME'] != '') ? sprintf('%s <%s>', $GLOBALS['TL_ADMIN_NAME'], $GLOBALS['TL_ADMIN_EMAIL']) : $GLOBALS['TL_ADMIN_EMAIL']);
		$objOffer->iso_mail_admin			= $this->iso_mail_admin;
		$objOffer->iso_mail_customer		= $this->iso_mail_customer;
		$objOrder->status					= '';
		$objOffer->new_offer_status		= 'pending';
		
		$objOffer->checkout_info	      = array(
				'billing_address' => array
				(
					'headline' => $GLOBALS['TL_LANG']['ISO']['billing_address'],
					'info' => $strBillingAddress,	
				)											
		);
		
		$strCustomerName = '';
		$strCustomerEmail = '';

		if ($_SESSION['FORM_DATA']['email'] != '')
		{
			$strCustomerName = $_SESSION['FORM_DATA']['firstname'] . ' ' . $_SESSION['FORM_DATA']['lastname'];
			$strCustomerEmail = $_SESSION['FORM_DATA']['email'];
		}		
		
		if (trim($strCustomerName) != '')
		{
			$strCustomerEmail = sprintf('"%s" <%s>', IsotopeEmail::romanizeFriendlyName($strCustomerName), $strCustomerEmail);
		}
		
		$objOffer->iso_customer_email	= $strCustomerEmail;	
		
		$arrData = array_merge($this->arrOfferData, array
		(
			'uniqid'				=> $objOffer->uniqid,
			'items'				=> $this->Isotope->Cart->items,
			'products'			=> $this->Isotope->Cart->products,
			'subTotal'			=> $this->Isotope->formatPriceWithCurrency($this->Isotope->Cart->subTotal, false),
			'taxTotal'			=> $this->Isotope->formatPriceWithCurrency($this->Isotope->Cart->taxTotal, false),
			'grandTotal'		=> $this->Isotope->formatPriceWithCurrency($this->Isotope->Cart->grandTotal, false),
			'cart_text'			=> strip_tags($this->replaceInsertTags($this->Isotope->Cart->getProducts('iso_products_text'))),
			'cart_html'			=> $this->replaceInsertTags($this->Isotope->Cart->getProducts('iso_products_html')),
		));

		$objOffer->email_data = $arrData;
		$objOffer->checkout();
		$objOffer->save();
	}	
}