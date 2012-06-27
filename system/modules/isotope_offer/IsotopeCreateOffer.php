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
 
 class IsotopeCreateOffer extends Frontend
{
	
	protected function __construct()
	{
		parent::__construct();		
		$this->import('Database');		
		$this->import('Email');
		$this->import('Input');
		$this->import('FrontendUser', 'User');
	}
	
	public function myProcessFormData($arrPost, $arrForm, $arrFiles)
	{
		if ( $arrPost['FORM_SUBMIT'] == $GLOBALS['TL_ICO']['form'] ) 
		{			
			$objAttribute = $this->Database->prepare("SELECT id FROM tl_member WHERE email=? LIMIT 1")
			                               ->execute($arrPost['email']);
			     
	    	if ( !$objAttribute->id ) 
	    	{
	    		$password = $this->generatePW(10);
				$userdata = array
				(
					'tstamp'    => time(),
					'dateAdded' => time(),
					'username'  => $arrPost['email'],
					'login'     => 1,	
					'password'  => sha1($GLOBALS['TL_CONFIG']['encryptionKey'] . $password).':'.$GLOBALS['TL_CONFIG']['encryptionKey']			
				);			
			
				foreach ($arrPost as $k=>$v)
				{
					if ( $k != 'FORM_SUBMIT' && $k != 'REQUEST_TOKEN' && $k != 'MAX_FILE_SIZE' )
					{
						$userdata[$k] = $v;
					}
				} 	  			
	    		
	    		$this->Database->prepare("INSERT INTO tl_member %s" )->set($userdata)->execute();	
	    		
				# E-Mail versenden
			   $this->Email->subject  = $GLOBALS['TL_LANG']['IsotopeCreateOffer']['subject'];
			   $this->Email->text     = sprintf
												  (
													 $GLOBALS['TL_LANG']['IsotopeCreateOffer']['message'], $userdata['email'], $password
												  );
			   
			   $this->Email->sendTo( $userdata['email'] );	 	    		
	    	}     	
		}
	}	
	
	public function myOutputFrontendTemplate($strContent, $strTemplate)
	{	
		if ( $this->User->authenticate() )
		{
			$userdata = array
			(
				'email'     => $this->User->email,
				'firstname' => $this->User->firstname,
				'lastname'  => $this->User->lastname,
				'phone'     => $this->User->phone,
			);				
		}		
		else 
		{
			$userdata = array
			(
				'email'     => $this->Input->post('email'),
				'firstname' => $this->Input->post('firstname'),
				'lastname'  => $this->Input->post('lastname'),
				'phone'     => $this->Input->post('phone'),
			);				
		}			
		
		if ( preg_match("/".$GLOBALS['TL_ICO']['site_offer']."/i", $strContent) &&  $strTemplate == 'fe_page' )
		{
			$userdata['subject'] = $userdata['firstname'] . ' ' . $userdata['lastname'] . ' (Tel.: ' . $userdata['phone'] . ') hat ein Angebot' . ' [cp-' . $userdata['lastname'] . '-' . date("d-m-Y-h-i-s") . '] erstellt.';	
	
			$this->send_mail($strContent, $userdata);
		}
		
		if ( preg_match("/".$GLOBALS['TL_ICO']['site_order']."/i", $strContent) &&  $strTemplate == 'fe_page' )
		{
			$userdata['subject'] = $userdata['firstname'] . ' ' . $userdata['lastname'] . ' (Tel.: ' . $userdata['phone'] . ') hat eine Musterbox angefordert.';	
	
			$this->send_mail($strContent, $userdata);
		}
				
		return $strContent;
	}
	
	protected function send_mail($strContent, $userdata)
	{		
	   # E-Mail versenden
	   $this->Email->from     = $userdata['email'];
	   $this->Email->fromName = $userdata['firstname'] . ' ' . $userdata['lastname'];
	   $this->Email->subject  = $userdata['subject'];
	   $this->Email->html     = $strContent;
	   
	   $this->Email->sendTo($GLOBALS['TL_ICO']['email']);	 	
	}
	
	protected function generatePW($length=8)
	{
 		$dummy	= array_merge(range('0', '9'), range('a', 'z'), range('A', 'Z'), array('#','&','@','$','_','%','?','+'));
 		mt_srand((double)microtime()*1000000);
		
		for ($i = 1; $i <= (count($dummy)*2); $i++)
		{
			$swap		= mt_rand(0,count($dummy)-1);
			$tmp		= $dummy[$swap];
			$dummy[$swap]	= $dummy[0];
			$dummy[0]	= $tmp;
		}
 
		return substr(implode('',$dummy),0,$length);
 	}
	
}
	