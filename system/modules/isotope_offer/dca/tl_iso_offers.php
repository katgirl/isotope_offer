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
 * Load tl_iso_products data container and language files
 */
$this->loadDataContainer('tl_iso_products');
$this->loadLanguageFile('tl_iso_products');


/**
 * Table tl_iso_offers
 */
$GLOBALS['TL_DCA']['tl_iso_offers'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'enableVersioning'            => false,
		'ctable'					  			=> array('tl_iso_offer_items'),
		'closed'            		  		=> true,
		'onload_callback' 			  	=> array
		(
			array('tl_iso_offers', 'checkPermission'),
		),
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 2,
			'fields'                  => array('date DESC'),
			'panelLayout'             => 'filter;sort,search,limit'
		),
		'label' => array
		(
			'fields'                  => array('offer_id', 'date', 'billing_address', 'grandTotal', 'status'),
			'showColumns'             => true,
			'label_callback'          => array('tl_iso_offers', 'getOfferLabel')
		),
		'global_operations' => array
		(
			'all' => array
			(
				'label'	              => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset();"'
			),
			'tools' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iso_offers']['tools'],
				'href'                => '',
				'class'               => 'header_isotope_tools',
				'attributes'          => 'onclick="Backend.getScrollOffset();" style="display:none"',
			),
			'export_emails' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iso_offers']['export_emails'],
				'href'                => 'key=export_emails',
				'class'               => 'header_iso_export_csv isotope-tools',
				'attributes'          => 'onclick="Backend.getScrollOffset();"'
			),
			'print_offers' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iso_offers']['print_offers'],
				'href'                => 'key=print_offers',
				'class'               => 'header_print_invoices isotope-tools',
				'attributes'          => 'onclick="Backend.getScrollOffset();"'
			)
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iso_offers']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iso_offers']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iso_offers']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			),
			'print_offer' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_iso_offers']['print_offer'],
				'href'                => 'key=print_offer',
				'icon'                => 'system/modules/isotope/html/document-pdf-text.png'
			),
		)
	),

	// Palettes
	'palettes' => array
	(
		'default'                     => '{status_legend},status,date_shipped;{details_legend},details,notes;{email_legend:hide},email_data;{billing_address_legend:hide},billing_address_data;{shipping_address_legend:hide},shipping_address_data',
	),

	// Fields
	'fields' => array
	(
		'id' => array
		(
			'eval'				=> array('doNotShow'=>true),
		),
		'pid' => array
		(
			'eval'				=> array('doNotShow'=>true),
		),
		'offer_id' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_iso_offers']['offer_id'],
			'search'				=> true,
			'sorting'			=> true,
		),
		'uniqid' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_iso_offers']['uniqid'],
			'search'				=> true,
		),
		'status' => array
		(
			'label'           => &$GLOBALS['TL_LANG']['tl_iso_offers']['status'],
			'filter'          => true,
			'sorting'			=> true,
			'inputType'       => 'select',
			'options'         => $GLOBALS['ISO_OFFER'],
			'reference'       => &$GLOBALS['TL_LANG']['OFFER'],
			'eval'				=> array('tl_class'=>'w50 wizard'),
		),
		'date' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_iso_offers']['date'],
			'flag'				=> 8,
			'filter'				=> true,
			'sorting'			=> true,
			'eval'				=> array('rgxp'=>'date', 'tl_class'=>'clr'),
		),
		'date_shipped' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_iso_offers']['date_shipped'],
			'inputType'			=> 'text',
			'eval'				=> array('rgxp'=>'date', 'datepicker'=>(method_exists($this,'getDatePickerString') ? $this->getDatePickerString() : true), 'tl_class'=>'w50 wizard'),
		),
		'billing_address' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_iso_offers']['billing_address'],
			'search'				=> true,
		),
		'surcharges' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_iso_offers']['surcharges'],
			'inputType'			=> 'surchargeWizard',
			'eval'				=> array('doNotShow'=>true),
			'save_callback'	=> array
			(
				array('tl_iso_offers','saveSurcharges')
			)
		),
		'details' => array
		(
			'input_field_callback'	=> array('tl_iso_offers', 'generateOfferDetails'),
			'eval'						=> array('doNotShow'=>true),
		),
		'grandTotal' => array
		(
			'label'					=> &$GLOBALS['TL_LANG']['tl_iso_offers']['grandTotal'],			
		),
		'notes' => array
		(
			'label'					=> &$GLOBALS['TL_LANG']['tl_iso_offers']['notes'],
			'inputType'				=> 'textarea',
			'eval'					=> array('style'=>'height:80px;')
		),
		'email_data' => array
		(
			'input_field_callback'	=> array('tl_iso_offers', 'generateEmailData'),
			'eval'						=> array('doNotShow'=>true),
		),
		'billing_address_data' => array
		(
			'input_field_callback'	=> array('tl_iso_offers', 'generateBillingAddressData'),
			'eval'						=> array('doNotShow'=>true),
		),
		'shipping_address_data' => array
		(
			'input_field_callback'	=> array('tl_iso_offers', 'generateShippingAddressData'),
			'eval'						=> array('doNotShow'=>true),
		),
	)
);


/**
 * Class tl_iso_offers
 * Provide miscellaneous methods that are used by the data configuration array.
 */
class tl_iso_offers extends Backend
{

	/**
	 * Import an Isotope object
	 */
	public function __construct()
	{
		parent::__construct();
		$this->import('Isotope');
	}


	/**
	 * Calculate and save surcharges
	 * @param mixed
	 * @param DataContainer
	 * @return mixed
	 */
	public function saveSurcharges($varValue, DataContainer $dc)
	{
		$fltTaxTotal = 0.00;
		$arrTaxables = array();
		$arrSurcharges = deserialize($varValue);

		if (!is_array($arrSurcharges) || !count($arrSurcharges))
		{
			return $varValue;
		}

		$arrAddresses['shipping'] = deserialize($dc->activeRecord->shipping_address);
		$arrAddresses['billing'] = deserialize($dc->activeRecord->billing_address);

		foreach ($arrSurcharges as $surcharge)
		{
			if ($surcharge['tax_class'] > 0)
			{
				$surcharge['before_tax'] = 1;
				$arrTaxables[] = $surcharge;
			}
		}

		foreach ($arrTaxables as $arrSurcharge)
		{
			$arrTax = array();

			// Skip taxes
			if (strpos($arrSurcharge['price'], '%')!==0)
			{
				$arrTax = $this->Isotope->calculateTax($arrSurcharge['tax_class'], $arrSurcharge['total_price'], $arrSurcharge['before_tax'], $arrAddresses);
			}

			foreach ($arrTax as $tax)
			{
				$fltTaxTotal += $tax['total_price'];
			}
		}

		foreach ($arrSurcharges as $row)
		{
			$arrSurchargePrices[] = array
			(
				'label' 		=> $row['label'],
				'total_price' 	=> $row['total_price'],
				'tax_class' 	=> $row['tax_class']
			);

			$arrTotalPrices[] = $row['total_price'];
		}

		// Adjust offer totals
		$fltGrandTotal = $dc->activeRecord->subTotal + array_sum($arrTotalPrices) + $fltTaxTotal;
		$this->Database->prepare("UPDATE tl_iso_offers SET grandTotal=? WHERE id=?")->execute($fltGrandTotal, $dc->id);

		return serialize($arrSurchargePrices);
	}


	/**
	 * Generate the offer label and return it as string
	 * @param array
	 * @param string
	 * @return string
	 */
	public function getOfferLabel($row, $label, DataContainer $dc, $args)
	{
		$this->Isotope->overrideConfig($row['config_id']);
		$strBillingAddress = $this->Isotope->generateAddressString(deserialize($row['billing_address']), $this->Isotope->Config->billing_fields);

		$args[2] = substr($strBillingAddress, 0, strpos($strBillingAddress, '<br />'));
		$args[3] = $this->Isotope->formatPriceWithCurrency($row['grandTotal']);
		
		return $args;
	}


	/**
	 * Generate the offer details view when editing an offer
	 * @param object
	 * @param string
	 * @return string
	 */
	public function generateOfferDetails($dc, $xlabel)
	{
		$objOffer = $this->Database->execute("SELECT * FROM tl_iso_offers WHERE id=".$dc->id);

		if (!$objOffer->numRows)
		{
			$this->redirect($this->Environment->script . '?act=error');
		}

		$GLOBALS['TL_CSS'][] = 'system/modules/isotope/html/print.css|print';

		// Generate a regular offer details module
		$this->Input->setGet('uid', $objOffer->uniqid);
		$objModule = new ModuleIsotopeOfferDetails($this->Database->execute("SELECT * FROM tl_module WHERE type='iso_offerdetails'"));
		return $objModule->generate(true);
	}


	/**
	 * Generate the offer details view when editing an offer
	 * @param object
	 * @param string
	 * @return string
	 */
	public function generateEmailData($dc, $xlabel)
	{
		$objOffer = $this->Database->execute("SELECT * FROM tl_iso_offers WHERE id=" . $dc->id);

		if (!$objOffer->numRows)
		{
			$this->redirect($this->Environment->script . '?act=error');
		}

		$arrSettings = deserialize($objOffer->settings, true);

		if (!is_array($arrSettings['email_data']))
		{
			return '<div class="tl_gerror">No email data available.</div>';
		}

		$strBuffer = '
<div>
<table cellpadding="0" cellspacing="0" class="tl_show" summary="Table lists all details of an entry" style="width:650px">
  <tbody>';

		$i=0;

		foreach ($arrSettings['email_data'] as $k => $v)
		{
			$strClass = ++$i%2 ? '' : ' class="tl_bg"';

			$strBuffer .= '
  <tr>
    <td' . $strClass . ' style="vertical-align:top"><span class="tl_label">'.$k.': </span></td>
    <td' . $strClass . '>'.((strip_tags($v) == $v) ? nl2br($v) : $v).'</td>
  </tr>';
		}

		$strBuffer .= '
</tbody></table>
</div>';

		return $strBuffer;
	}
	
	
	/**
	 * Generate the billing address details
	 * @param object
	 * @param string
	 * @return string
	 */
	public function generateBillingAddressData($dc, $xlabel)
	{
		return $this->generateAddressData($dc->id, 'billing_address');
	}
	
	
	/**
	 * Generate the shipping address details
	 * @param object
	 * @param string
	 * @return string
	 */
	public function generateShippingAddressData($dc, $xlabel)
	{
		return $this->generateAddressData($dc->id, 'shipping_address');
	}
	
	
	/**
	 * Generate address details amd return it as string
	 * @param integer
	 * @param string
	 * @return string
	 */
	protected function generateAddressData($intId, $strField)
	{
		$objOffer = $this->Database->execute("SELECT * FROM tl_iso_offers WHERE id=".$intId);

		if (!$objOffer->numRows)
		{
			$this->redirect('contao/main.php?act=error');
		}

		$arrAddress = deserialize($objOffer->$strField, true);

		if (!is_array($arrAddress))
		{
			return '<div class="tl_gerror">No address data available.</div>';
		}
		
		$this->loadDataContainer('tl_iso_addresses');

		$strBuffer = '
<div>
<table cellpadding="0" cellspacing="0" class="tl_show" summary="Table lists all details of an entry" style="width:650px">
  <tbody>';

		$i=0;

		foreach ($GLOBALS['TL_DCA']['tl_iso_addresses']['fields'] as $k => $v)
		{
			if (!isset($arrAddress[$k]))
			{
				continue;
			}
			
			$v = $arrAddress[$k];
			$strClass = (++$i % 2) ? '' : ' class="tl_bg"';

			$strBuffer .= '
  <tr>
    <td' . $strClass . ' style="vertical-align:top"><span class="tl_label">'.$this->Isotope->formatLabel('tl_iso_addresses', $k).': </span></td>
    <td' . $strClass . '>'.$this->Isotope->formatValue('tl_iso_addresses', $k, $v).'</td>
  </tr>';
		}

		$strBuffer .= '
</tbody></table>
</div>';

		return $strBuffer;
	}


	/**
	* Review offer page stores temporary information in this table to know it when user is redirected to a payment provider. We do not show this data in backend.
	* @param object
	* @return void
	*/
	public function checkPermission($dc)
	{
		$this->import('BackendUser', 'User');
		$arrConfigs = $this->User->iso_configs;

		if ($this->User->isAdmin || (is_array($arrConfigs) && count($arrConfigs)))
		{
			$arrIds = $this->Database->execute("SELECT id FROM tl_iso_offers WHERE status!=''" . ($this->User->isAdmin ? '' : " AND config_id IN (".implode(',', $arrConfigs).")"))->fetchEach('id');
		}

		if (!count($arrIds))
		{
			$arrIds = array(0);
		}

		$GLOBALS['TL_DCA']['tl_iso_offers']['list']['sorting']['root'] = $arrIds;

		if (!$this->User->isAdmin)
		{
			unset($GLOBALS['TL_DCA']['tl_iso_offers']['list']['operations']['delete']);

			if ($this->Input->get('act') == 'delete' || $this->Input->get('act') == 'deleteAll')
			{
				$this->log('Only admin can delete offers!', __METHOD__, TL_ERROR);
				$this->redirect($this->Environment->script.'?act=error');
			}
			elseif (strlen($this->Input->get('id')) && !in_array($this->Input->get('id'), $arrIds))
			{
				$this->log('Trying to access disallowed offer ID '.$this->Input->get('id'), __METHOD__, TL_ERROR);
				$this->redirect($this->Environment->script.'?act=error');
			}
		}
	}


	/**
	 * Export offer e-mails and send them to browser as file
	 * @param DataContainer
	 * @return string
	 * @todo offers should be sorted, but by ID or date? also might want to respect user filter/search
	 */
	public function exportOfferEmails(DataContainer $dc)
	{
		if ($this->Input->get('key') != 'export_emails')
		{
			return '';
		}

		$arrExport = array();
		$objOffers = $this->Database->execute("SELECT billing_address FROM tl_iso_offers");

		while ($objOffers->next())
		{
			$arrAddress = deserialize($objOffers->billing_address);

			if ($arrAddress['email'])
			{
				$arrExport[] = $arrAddress['firstname'] . ' ' . $arrAddress['lastname'] . ' <' . $arrAddress['email'] . '>';
			}
		}

		if (!count($arrExport))
		{
			return '
<div id="tl_buttons">
<a href="'.ampersand(str_replace('&key=export_emails', '', $this->Environment->request)).'" class="header_back" title="'.specialchars($GLOBALS['TL_LANG']['MSC']['backBT']).'">'.$GLOBALS['TL_LANG']['MSC']['backBT'].'</a>
</div>
<p class="tl_gerror">'. $GLOBALS['TL_LANG']['MSC']['noOfferEmails'] .'</p>';
		}

		header('Content-Type: application/csv');
		header('Content-Transfer-Encoding: binary');
		header('Content-Disposition: attachment; filename="isotope_offer_emails_export_' . time() .'.csv"');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		header('Expires: 0');

		$output = '';

		foreach ($arrExport as $export)
		{
			$output .= '"' . $export . '"' . "\n";
		}

		echo $output;
		exit;
	}


	/**
	 * Provide a select menu to choose offers by status and print PDF
	 * @return string
	 */
	public function printOffers()
	{
		$strMessage = '';

		$strReturn = '
<div id="tl_buttons">
<a href="'.ampersand(str_replace('&key=print_offers', '', $this->Environment->request)).'" class="header_back" title="'.specialchars($GLOBALS['TL_LANG']['MSC']['backBT']).'">'.$GLOBALS['TL_LANG']['MSC']['backBT'].'</a>
</div>

<h2 class="sub_headline">'.$GLOBALS['TL_LANG']['tl_iso_offers']['print_offers'][0].'</h2>
<form action="'.$this->Environment->request.'"  id="tl_print_offers" class="tl_form" method="post">
<input type="hidden" name="FORM_SUBMIT" value="tl_print_offers">
<input type="hidden" name="REQUEST_TOKEN" value="'.REQUEST_TOKEN.'">
<div class="tl_formbody_edit">
<div class="tl_tbox block">';

		$objWidget = new SelectMenu($this->prepareForWidget($GLOBALS['TL_DCA']['tl_iso_offers']['fields']['status'], 'status'));

		if ($this->Input->post('FORM_SUBMIT') == 'tl_print_offers')
		{
			$objOffers = $this->Database->prepare("SELECT id FROM tl_iso_offers WHERE status=?")->execute($this->Input->post('status'));

			if ($objOffers->numRows)
			{
				$this->generateOffers($objOffers->fetchEach('id'));
			}
			else
			{
				$strMessage = '<p class="tl_gerror">'.$GLOBALS['TL_LANG']['MSC']['noOffers'].'</p>';
			}
		}

		return $strReturn . $strMessage . $objWidget->parse() . '
</div>
</div>
<div class="tl_formbody_submit">
<div class="tl_submit_container">
<input type="submit" name="print_offers" id="ctrl_print_offers" value="'.$GLOBALS['TL_LANG']['MSC']['labelSubmit'].'">
</div>
</div>
</form>
</div>';
	}


	/**
	 * Print one offer as PDF
	 * @param DataContainer
	 * @return void
	 */
	public function printOffer(DataContainer $dc)
	{
		$this->generateOffers(array($dc->id));
	}


	/**
	 * Generate one or multiple PDFs by offer ID
	 * @param array
	 * @return void
	 */
	public function generateOffers(array $arrIds)
	{
		$this->import('Isotope');

		if (!count($arrIds))
		{
			$this->log('No offer IDs passed to method.', __METHOD__, TL_ERROR);
			$this->redirect($this->Environment->script . '?act=error');
		}

		$pdf = null;

		foreach ($arrIds as $intId)
		{
			$objOffer = new IsotopeOffer();

			if ($objOffer->findBy('id', $intId))
			{
				$pdf = $objOffer->generatePDF(null, $pdf, false);
			}
		}

		if (!$pdf)
		{
			$this->log('No offer IDs passed to method.', __METHOD__, TL_ERROR);
			$this->redirect($this->Environment->script . '?act=error');
		}

		// Close and output PDF document
		$pdf->lastPage();

		// @todo make things like this configurable in a further version of Isotope
		$strOfferTitle = 'offer_' . $objOffer->offer_id;
		$pdf->Output(standardize(ampersand($strOfferTitle, false), true) . '.pdf', 'D');

		// Set config back to default
		// @todo do we need that? The PHP session is ended anyway...
		$this->Isotope->resetConfig(true);

		// Stop script execution
		exit;
	}
}

