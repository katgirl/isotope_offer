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

$GLOBALS['TL_LANG']['tl_iso_offers']['offer_id'][0] = 'Angebotsnummer';
$GLOBALS['TL_LANG']['tl_iso_offers']['uniqid'][0] = 'Eindeutige ID';
$GLOBALS['TL_LANG']['tl_iso_offers']['status'][0] = 'Angebotsstatus';
$GLOBALS['TL_LANG']['tl_iso_offers']['status'][1] = 'Wählen Sie den Status der Angebot.';
$GLOBALS['TL_LANG']['tl_iso_offers']['date_shipped'][0] = 'Versanddatum';
$GLOBALS['TL_LANG']['tl_iso_offers']['date_shipped'][1] = 'Geben Sie an wann (Datum) diese Angebot versandt wurde.';
$GLOBALS['TL_LANG']['tl_iso_offers']['date'][0] = 'Datum';
$GLOBALS['TL_LANG']['tl_iso_offers']['shipping_address'][0] = 'Versand-Adresse';
$GLOBALS['TL_LANG']['tl_iso_offers']['billing_address'][0] = 'Rechnungs-Adresse';
$GLOBALS['TL_LANG']['tl_iso_offers']['offer_subtotal'][0] = 'Zwischensumme';
$GLOBALS['TL_LANG']['tl_iso_offers']['offer_tax'][0] = 'Umsatzsteuer-Betrag';
$GLOBALS['TL_LANG']['tl_iso_offers']['shippingTotal'][0] = 'Versandkosten';
$GLOBALS['TL_LANG']['tl_iso_offers']['surcharges'][0] = 'Aufpreise';
$GLOBALS['TL_LANG']['tl_iso_offers']['notes'][0] = 'Angebotsanmerkungen';
$GLOBALS['TL_LANG']['tl_iso_offers']['notes'][1] = 'Wenn Sie für andere Backend-Nutzer hinterlegen möchten, tun Sie das bitte hier.';
$GLOBALS['TL_LANG']['tl_iso_offers']['opLabel'] = 'Name des Aufpreises';
$GLOBALS['TL_LANG']['tl_iso_offers']['opPrice'] = 'Preis';
$GLOBALS['TL_LANG']['tl_iso_offers']['opTaxClass'] = 'Steuerklasse';
$GLOBALS['TL_LANG']['tl_iso_offers']['opAddTax'] = 'Steuer hinzufügen?';
$GLOBALS['TL_LANG']['tl_iso_offers']['new'][0] = 'Neue Angebot';
$GLOBALS['TL_LANG']['tl_iso_offers']['new'][1] = 'Eine neue Angebot erstellen';
$GLOBALS['TL_LANG']['tl_iso_offers']['edit'][0] = 'Angebot bearbeiten';
$GLOBALS['TL_LANG']['tl_iso_offers']['edit'][1] = 'Angebot ID %s bearbeiten';
$GLOBALS['TL_LANG']['tl_iso_offers']['copy'][0] = 'Angebot duplizieren';
$GLOBALS['TL_LANG']['tl_iso_offers']['copy'][1] = 'Angebot ID %s duplizieren';
$GLOBALS['TL_LANG']['tl_iso_offers']['delete'][0] = 'Angebot löschen';
$GLOBALS['TL_LANG']['tl_iso_offers']['delete'][1] = 'Angebot ID %s löschen';
$GLOBALS['TL_LANG']['tl_iso_offers']['show'][0] = 'Angebotsdetails';
$GLOBALS['TL_LANG']['tl_iso_offers']['show'][1] = 'Details der Angebot ID %s anzeigen';
$GLOBALS['TL_LANG']['tl_iso_offers']['edit_offer'][0] = 'Angebot bearbeiten';
$GLOBALS['TL_LANG']['tl_iso_offers']['edit_offer'][1] = 'Angebotsartikel bearbeiten, Produkte hinzufügen oder entfernen.';
$GLOBALS['TL_LANG']['tl_iso_offers']['edit_offer_items'][0] = 'Angebotsartikel bearbeiten';
$GLOBALS['TL_LANG']['tl_iso_offers']['edit_offer_items'][1] = 'Bearbeite Artikel der Angebot ID %s';
$GLOBALS['TL_LANG']['tl_iso_offers']['print_offer'][0] = 'Angebot drucken';
$GLOBALS['TL_LANG']['tl_iso_offers']['print_offer'][1] = 'Diese Angebot drucken';
$GLOBALS['TL_LANG']['tl_iso_offers']['authorize_process_payment'][1] = 'Eine Transaktion mit dem Authorize.net point-of-sale Terminal ausführen.';
$GLOBALS['TL_LANG']['tl_iso_offers']['tools'][0] = 'Werkzeuge';
$GLOBALS['TL_LANG']['tl_iso_offers']['tools'][1] = 'Weitere Optionen für das Angebots-Management';
$GLOBALS['TL_LANG']['tl_iso_offers']['export_emails'][0] = 'Exportiere Angebots-E-Mails';
$GLOBALS['TL_LANG']['tl_iso_offers']['export_emails'][1] = 'Alle E-Mails für diejenigen die bestellten exportieren.';
$GLOBALS['TL_LANG']['tl_iso_offers']['print_offers'][0] = 'Angebote drucken';
$GLOBALS['TL_LANG']['tl_iso_offers']['print_offers'][1] = 'Eine oder mehrere Angebote in ein Einzeldokument eines bestimmten Angebotsstatus\' drucken.';
$GLOBALS['TL_LANG']['tl_iso_offers']['grandTotal'][0] = 'Angebotssumme';
$GLOBALS['TL_LANG']['tl_iso_offers']['grandTotal'][1] = 'Summe des Angebotes';

/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_iso_offers']['status_legend'] = 'Angebotsstatus';
$GLOBALS['TL_LANG']['tl_iso_offers']['details_legend'] = 'Angebotsdetails';
$GLOBALS['TL_LANG']['tl_iso_offers']['email_legend']	= 'E-Mail Daten';
$GLOBALS['TL_LANG']['tl_iso_offers']['billing_address_legend']	= 'Angebotsadress-Daten';
$GLOBALS['TL_LANG']['tl_iso_offers']['shipping_address_legend']	= 'Versandadress-Daten';

