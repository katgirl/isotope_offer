-- **********************************************************
-- *                                                        *
-- * IMPORTANT NOTE                                         *
-- *                                                        *
-- * Do not import this file manually but use the Contao    *
-- * install tool to create and maintain database tables!   *
-- *                                                        *
-- **********************************************************

--
-- Table `tl_iso_offers`
-- pid == member ID
--

CREATE TABLE `tl_iso_offers` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `pid` int(10) unsigned NOT NULL default '0',
  `tstamp` int(10) unsigned NOT NULL default '0',
  `settings` blob NULL,
  `date` int(10) unsigned NOT NULL default '0',
  `date_paid` varchar(10) NOT NULL default '',
  `date_shipped` varchar(10) NOT NULL default '',
  `status` varchar(32) NOT NULL default '',

  `offer_id` varchar(14) NOT NULL default '',
  `uniqid` varchar(27) NOT NULL default '',

  `config_id` int(10) unsigned NOT NULL default '0',
  `cart_id` int(10) unsigned NOT NULL default '0',
  `payment_id` int(10) unsigned NOT NULL default '0',
  `shipping_id` int(10) unsigned NOT NULL default '0',
  `language` varchar(2) NOT NULL default '',
  `shipping_address` blob NULL,
  `billing_address` blob NULL,
  `checkout_info` blob NULL,
  `surcharges` blob NULL,
  `coupons` blob NULL,
  `payment_data` blob NULL,
  `shipping_data` blob NULL,
  `subTotal` decimal(12,2) NOT NULL default '0.00',
  `taxTotal` decimal(12,2) NOT NULL default '0.00',
  `shippingTotal` decimal(12,2) NOT NULL default '0.00',
  `grandTotal` decimal(12,2) NOT NULL default '0.00',
  `cc_num` varchar(64) NOT NULL default '',
  `cc_type` varchar(32) NOT NULL default '',
  `cc_exp` varchar(16) NOT NULL default '',
  `cc_cvv` varchar(8) NOT NULL default '',
  `currency` varchar(4) NOT NULL default '',
  `notes` text NULL,
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


--
-- Table `tl_iso_offer_items`
--

CREATE TABLE `tl_iso_offer_items` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `pid` int(10) unsigned NOT NULL default '0',
  `tstamp` int(10) unsigned NOT NULL default '0',
  `product_id` int(10) unsigned NOT NULL default '0',
  `product_sku` varchar(128) NOT NULL default '',
  `product_name` varchar(255) NOT NULL default '',
  `product_options` blob NULL,
  `product_quantity` int(10) unsigned NOT NULL default '0',
  `price` decimal(12,2) NOT NULL default '0.00',
  `tax_id` varchar(32) NOT NULL default '',
  `href_reader` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


--
-- Table `tl_iso_config`
--

CREATE TABLE `tl_iso_config` (
	`offerPrefix` varchar(5) NOT NULL default '',
	`offerDigits` int(1) unsigned NOT NULL default '4',
) ENGINE=MyISAM DEFAULT CHARSET=utf8;