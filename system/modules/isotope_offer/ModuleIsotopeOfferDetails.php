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
 * Class ModuleIsotopeOfferDetails
 * Front end module Isotope "offer details".
 */
 
class ModuleIsotopeOfferDetails extends ModuleIsotope
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_iso_offerdetails';

	/**
	 * Disable caching of the frontend page if this module is in use
	 * @var boolean
	 */
	protected $blnDisableCache = true;


	/**
	 * Display a wildcard in the back end
	 * @return string
	 */
	public function generate($blnBackend=false)
	{
		if (TL_MODE == 'BE' && !$blnBackend)
		{
			$objTemplate = new BackendTemplate('be_wildcard');

			$objTemplate->wildcard = '### ISOTOPE ECOMMERCE: OFFER DETAILS ###';
			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
			$objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

			return $objTemplate->parse();
		}

		if ($blnBackend)
		{
			$this->backend = true;
			$this->jumpTo = 0;
		}

		return parent::generate();
	}


	/**
	 * Generate the module
	 * @return void
	 */
	protected function compile()
	{
		global $objPage;
		$objOffer = new IsotopeOffer();

		if (!$objOffer->findBy('uniqid', $this->Input->get('uid')))
		{
			$this->Template = new FrontendTemplate('mod_message');
			$this->Template->type = 'error';
			$this->Template->message = $GLOBALS['TL_LANG']['ERR']['offerNotFound'];
			return;
		}

		$arrOffer = $objOffer->getData();
		$this->Template->setData($arrOffer);

		$this->import('Isotope');
		$this->Isotope->overrideConfig($objOffer->config_id);

		// Article reader
		$arrPage = $this->Database->prepare("SELECT * FROM tl_page WHERE id=?")->limit(1)->execute($this->jumpTo)->fetchAssoc();


		$arrItems = array();
		$arrProducts = $objOffer->getProducts();

		foreach ($arrProducts as $i => $objProduct)
		{
			$arrItems[] = array
			(
				'raw'					=> $objProduct->getData(),
				'sku'					=> $objProduct->sku,
				'name'				=> $objProduct->name,
				'image'				=> $objProduct->images->main_image,
				'product_options'	=> $objProduct->getOptions(),
				'quantity'			=> $objProduct->quantity_requested,
				'price'				=> $this->Isotope->formatPriceWithCurrency($objProduct->price),
				'total'				=> $this->Isotope->formatPriceWithCurrency($objProduct->total_price),
				'href'				=> ($this->jumpTo ? $this->generateFrontendUrl($arrPage, '/product/'.$objProduct->alias) : ''),
				'tax_id'				=> $objProduct->tax_id,
			);
		}

		$this->Template->info = deserialize($objOffer->checkout_info, true);
		$this->Template->items = IsotopeFrontend::generateRowClass($arrItems, 'row', 'rowClass', 0, ISO_CLASS_COUNT|ISO_CLASS_FIRSTLAST|ISO_CLASS_EVENODD);


		$this->Template->raw = $arrOffer;

		$this->Template->date = $this->parseDate($GLOBALS['TL_CONFIG']['dateFormat'], $objOffer->date);
		$this->Template->time = $this->parseDate($GLOBALS['TL_CONFIG']['timeFormat'], $objOffer->date);
		$this->Template->datim = $this->parseDate($GLOBALS['TL_CONFIG']['datimFormat'], $objOffer->date);
		$this->Template->offerDetailsHeadline = sprintf($GLOBALS['TL_LANG']['MSC']['offerDetailsHeadline'], $objOffer->offer_id, $this->Template->datim);
		$this->Template->offerStatus = sprintf($GLOBALS['TL_LANG']['MSC']['offerStatusHeadline'], $GLOBALS['TL_LANG']['OFFER'][$objOffer->status]);
		$this->Template->offerStatusKey = $objOffer->status;
		$this->Template->subTotalPrice = $this->Isotope->formatPriceWithCurrency($objOffer->subTotal);
		$this->Template->grandTotal = $this->Isotope->formatPriceWithCurrency($objOffer->grandTotal);
		$this->Template->subTotalLabel = $GLOBALS['TL_LANG']['MSC']['subTotalLabel'];
		$this->Template->grandTotalLabel = $GLOBALS['TL_LANG']['MSC']['grandTotalLabel'];
		$this->Template->surcharges = IsotopeFrontend::formatSurcharges($objOffer->getSurcharges());
		$this->Template->billing_label = $GLOBALS['TL_LANG']['ISO']['billing_address'];
		$this->Template->billing_address = $this->Isotope->generateAddressString($objOffer->billing_address, $this->Isotope->Config->billing_fields);

	}
}

